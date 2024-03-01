from django.views.generic import ListView, DetailView
from django.views.generic.edit import CreateView, UpdateView, DeleteView
from django.urls import reverse_lazy
from django.contrib.messages.views import SuccessMessageMixin

from .models import Post


class BlogListView(ListView):
    model = Post
    paginate_by = 2
    template_name = "post/post_list.html"


class BlogDetailView(DetailView):
    model = Post
    template_name = "post/post_detail.html"


class BlogCreateView(SuccessMessageMixin, CreateView):
    model = Post
    template_name = "post/post_new.html"
    fields = ["name", "description", "featured_image"]
    success_message = "%(name)s успешно создан"


class BlogUpdateView(SuccessMessageMixin, UpdateView):
    model = Post
    template_name = "post/post_edit.html"
    fields = ["name", "description", "featured_image"]
    success_message = "%(name)s успешно обновлен"


class BlogDeleteView(DeleteView):
    model = Post
    template_name = "post/post_delete.html"
    success_url = reverse_lazy("post_list")
