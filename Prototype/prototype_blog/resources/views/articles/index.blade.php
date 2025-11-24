@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2>Liste des articles</h2>
            </div>
        </div>

        <!-- Filtre par catégorie -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Filtrer par catégorie</h5>
                <div class="row">
                    <div class="col-md-4">
                        <select class="form-select" id="categoryFilter" onchange="window.location.href=this.value">
                            <option value="{{ route('articles.index') }}" {{ is_null($category) ? 'selected' : '' }}>Toutes
                                les catégories</option>
                            @foreach($categories as $cat)
                                <option value="{{ route('articles.index', ['category' => $cat]) }}" {{ $category === $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des articles -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Catégories</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $article)
                                <tr>
                                    <td>{{ $article->id }}</td>
                                    <td>{{ $article->title }}</td>
                                    <td>
                                        @foreach($article->tags as $tag)
                                            <span class="badge bg-secondary">{{ $tag->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $article->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="d-flex gap-2">
                                        <a href="{{ route('articles.edit', $article->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger delete-article"
                                            data-id="{{ $article->id }}" data-title="{{ $article->title }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Aucun article trouvé</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($articles->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-start">
                            {{ $articles->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer l'article "<span id="articleTitle"></span>" ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Gestion de la suppression avec confirmation
            const deleteButtons = document.querySelectorAll('.delete-article');
            const deleteForm = document.getElementById('deleteForm');
            const articleTitle = document.getElementById('articleTitle');
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const articleId = this.getAttribute('data-id');
                    const title = this.getAttribute('data-title');

                    // Mise à jour du formulaire
                    deleteForm.action = `/articles/${articleId}`;
                    articleTitle.textContent = title;

                    // Affichage de la modal
                    deleteModal.show();
                });
            });

            // Gestion de la soumission du formulaire en AJAX
            deleteForm.addEventListener('submit', function (e) {
                e.preventDefault();

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Afficher un message de succès
                            const toastEl = document.createElement('div');
                            toastEl.className = 'toast align-items-center text-white bg-success border-0 position-fixed bottom-0 end-0 m-3';
                            toastEl.setAttribute('role', 'alert');
                            toastEl.setAttribute('aria-live', 'assertive');
                            toastEl.setAttribute('aria-atomic', 'true');
                            toastEl.innerHTML = `
                        <div class="d-flex">
                            <div class="toast-body">
                                ${data.message}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    `;
                            document.body.appendChild(toastEl);
                            const toast = new bootstrap.Toast(toastEl);
                            toast.show();

                            // Supprimer la ligne du tableau après un délai
                            setTimeout(() => {
                                const row = document.querySelector(`button[data-id="${data.article_id}"]`).closest('tr');
                                if (row) {
                                    row.style.transition = 'opacity 0.5s';
                                    row.style.opacity = '0';
                                    setTimeout(() => row.remove(), 500);
                                }
                            }, 1000);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue lors de la suppression.');
                    })
                    .finally(() => {
                        deleteModal.hide();
                    });
            });
        });
    </script>
@endpush