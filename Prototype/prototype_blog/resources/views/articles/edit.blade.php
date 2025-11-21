@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Modifier l'article</h3>
                    <a href="{{ route('articles.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('articles.update', $article) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" 
                                   value="{{ old('title', $article->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Contenu</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                     id="content" name="content" rows="6" required>{{ old('content', $article->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label d-block">Catégories</label>
                            <div class="d-flex flex-wrap gap-3">
                                @forelse($categories as $category)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="tags[]" 
                                               value="{{ $category->id }}"
                                               id="tag_{{ $category->id }}"
                                               {{ in_array($category->id, $article->tags->pluck('id')->toArray()) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tag_{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-muted">Aucune catégorie disponible</p>
                                @endforelse
                            </div>
                            @error('tags')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-check {
        padding: 0.5rem 1rem;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        margin: 0;
        transition: all 0.2s;
    }
    .form-check:hover {
        background-color: #f8f9fa;
    }
    .form-check-input {
        margin-top: 0.25rem;
        margin-right: 0.5rem;
    }
    .form-check-label {
        cursor: pointer;
    }
</style>
@endpush
