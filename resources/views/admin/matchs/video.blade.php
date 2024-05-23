<div class="card-body">
    <div class="table-wrapper">
        <table class="table caption-top responsive-table">
            <caption>
                {{ $all_product->appends(['search' => $search ?? null])->links('front.components.pagination') }}
            </caption>
            <thead>
                <tr>
                    <th scope="col">Titre</th>
                    <th scope="col">Url</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($all_product as $key => $item)
                    <tr>
                        <th scope="row">
                            {{ $item->title }}
                        </th>
                        <td>{{ $item->url }}</td>

                        <td class="d-flex align-items-center">
                            <button class="btn btn-danger mx-2" type="button"data-bs-toggle="modal"
                                data-bs-target="#delete{{ $key }}"><i class="fas fa-trash-alt"></i></button>

                            <!-- Modal delete -->
                            <div class="modal fade" id="delete{{ $key }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="delete{{ $key }}Label"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="delete{{ $key }}Label">
                                                Supprimer
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('delete.video', $item['id']) }}"
                                            class="modal-body">
                                            @csrf
                                            <div class="mb-3 d-flex align-items-center">
                                                <label class="form-label mb-0">Vous voullez
                                                    vraiment
                                                    supprimer ce match</label>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-primary">Valider</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <!-- End Modal delete -->
                            <button class="btn btn-warning mx-2" type="button" data-bs-toggle="modal"
                                data-bs-target="#modify{{ $key }}"><i class="fas fa-edit"></i></button>

                            <!-- Modal Update -->
                            <div class="modal fade" id="modify{{ $key }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="modify{{ $key }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="modify{{ $key }}Label">
                                                Modification
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('update.video', $item['id']) }}"
                                            enctype="multipart/form-data" class="modal-body">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Title</label>
                                                <input class="form-control" id="title" name="title"
                                                    value="{{ $item->title }}" type="text" autocomplete="title">
                                            </div>
                                            <div class="mb-3">
                                                <label for="titleNewMatch" class="form-label">Url de la vidéo</label>
                                                <input type="text"
                                                    class="form-control @error('url') is-invalid @enderror"
                                                    name="url" value="{{ $item['url'] }}" required
                                                    autocomplete="url" autofocus id="titleNewMatch">
                                                @error('url')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <button title="Voir details" class="btn btn-success mx-2" type="button"
                                data-bs-toggle="modal" data-bs-target="#DetailsMatch-{{ $key }}"><i
                                    class="fas fa-eye"></i></button>

                            <!-- Modal detail -->
                            <div class="modal fade" id="DetailsMatch-{{ $key }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="DetailsMatch-{{ $key }}-Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="DetailsMatch-{{ $key }}-Label">
                                                {{ $item->title }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="details my-3">
                                                <div class="d-flex align-center justify-content-between">
                                                    <p class="font-weight-bold">
                                                        Titre
                                                    </p>
                                                    <p>
                                                        {{ $item->title }}
                                                    </p>
                                                </div>
                                                <div class="d-flex align-center justify-content-between">
                                                    <p class="font-weight-bold">
                                                        Url
                                                    </p>
                                                    <p>
                                                        {{ $item->url }}
                                                    </p>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- end modal detail  --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
