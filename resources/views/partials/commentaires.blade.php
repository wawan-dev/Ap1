@foreach($commentaires as $commentaire)
    <div class="border-bottom mb-2 pb-2">
        <p><strong>{{ $commentaire->equipe->nomequipe }}:</strong> {{ $commentaire->commentaire }}</p>
    </div>
@endforeach
