<?php

namespace App;

class Auth
{
    public function __construct(
        private readonly \PDO $db,
    ) {
    }

    public function user()
    {
        if (!$this->check()) {
            return false;
        }

        $sth = $this->db->prepare('SELECT id,first_name,last_name,email FROM users WHERE id=:id LIMIT 1');
        $sth->bindValue(':id', $_SESSION['user']);
        $sth->execute();

        $user = $sth->fetch(\PDO::FETCH_OBJ);

        return $user;
    }

    public function check()
    {
        return isset($_SESSION['user']);
    }

    public function attempt($email, $password, $remember_me)
    {
        $sth = $this->db->prepare('SELECT id, password FROM users WHERE email=:email LIMIT 1');
        $sth->bindValue(':email', $email);
        $sth->execute();

        $user = $sth->fetch(\PDO::FETCH_OBJ);


        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            if (password_needs_rehash($password, PASSWORD_DEFAULT)) {
                $this->passwordNeedsRehash($password, $$email);
            }

            session_regenerate_id();

            $_SESSION['user'] = $user->id;

            if ($remember_me) {
                $this->setRememberToken($user);
            }

            return true;
        }

        return false;
    }

    public function logout()
    {
        unset($_SESSION['user']);

        setcookie("remember", null, [
            'expires' => -2628000,
            'httpOnly' => true
        ]);
    }

    public function getUserByRememberIdentifier($identifier)
    {
        $sth = $this->db->prepare('SELECT id,first_name,last_name,email FROM users WHERE remember_identifier=:remember_identifier LIMIT 1');
        $sth->bindValue(':remember_identifier', $identifier);
        $sth->execute();

        return $sth->fetch(\PDO::FETCH_OBJ);
    }

    public function setUserSession($user)
    {
        $_SESSION['user'] = $user->id;
    }

    private function passwordNeedsRehash($password, $email)
    {
        // PASSWORD_DEFAULT
        // PASSWORD_BCRYPT
        // PASSWORD_ARGON2I
        // PASSWORD_ARGON2ID
        //  задаёт необходимую алгоритмическую сложность.

        $newHash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
        $stmt = $this->db->prepare('UPDATE users SET password = :password WHERE email = :email');
        $stmt->execute([
            'email' => $email,
            'password' => $newHash,
        ]);
    }

    private function setRememberToken($user)
    {
        $identifier = $this->generateIdentifier();

        setcookie("remember", $identifier, [
            'expires' => time() + 86400,
            'httpOnly' => true
        ]);

        $stmt = $this->db->prepare('UPDATE users SET remember_identifier = :identifier WHERE id = :id');
        $stmt->execute([
            'id' => $user->id,
            'identifier' => $identifier,
        ]);
    }

    private function generateIdentifier()
    {
        return bin2hex(random_bytes(32));
    }
}
