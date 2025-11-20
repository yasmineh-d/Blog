{{-- Titre de la page --}}
<h2 style="margin-bottom:20px;">Liste des Articles</h2>

{{-- Message de succès après suppression --}}
@if(session('status'))
    <div style="padding:10px; background:#c8ffc8; margin-bottom:15px;">
        {{ session('status') }}
    </div>
@endif

{{-- Filtre par catégorie --}}
<form method="GET" action="{{ route('articles.index') }}" style="margin-bottom:20px;">
    <label>Filtrer par catégorie :</label>

    <select name="category" onchange="this.form.submit()">
        <option value="">Toutes les catégories</option>

        {{-- Boucle sur les catégories --}}
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}"
                {{ request('category') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
</form>

{{-- Tableau des articles --}}
<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <tr style="background:#f0f0f0;">
        <th>ID</th>
        <th>Titre</th>
        <th>Catégories</th>
        <th>Date</th>
        <th>Action</th>
    </tr>

    {{-- Boucle sur les articles --}}
    @foreach($articles as $article)
        <tr>
            <td>{{ $article->id }}</td>
            <td>{{ $article->title }}</td>

            {{-- Affichage des tags liés --}}
            <td>
                @foreach($article->tags as $tag)
                    <span style="background:#ddd; padding:3px 6px; border-radius:4px;">
                        {{ $tag->name }}
                    </span>
                @endforeach
            </td>

            {{-- Date formatée --}}
            <td>{{ $article->created_at->format('d/m/Y') }}</td>

            {{-- Bouton de suppression --}}
            <td>
                <form action="{{ route('articles.destroy', $article) }}"
                      method="POST"
                      onsubmit="return confirm('Voulez-vous vraiment supprimer cet article ?');">

                    @csrf
                    @method('DELETE')

                    <button style="background:red; color:white; padding:5px 10px; border:none;">
                        Supprimer
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

{{-- Pagination --}}
<div style="margin-top:20px;">
    {{ $articles->links() }}
</div>
