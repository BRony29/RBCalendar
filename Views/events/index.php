<?php $_SESSION['redirect'] = '/events/index'; ?>

<section id="events" class="container">
    <div class="row">
        <div class="col-sm-12 my-auto px-0">
            <div class="d-flex flex-row align-items-center justify-content-between mx-2">
                <h5>Liste des évènements</h5>
                <div>
                    <a href="/calendar/index" class="btn btn-dark btn-sm mx-2" role="button" title="Vue Calendar"><i class="far fa-calendar"></i></a>
                    <button class="btn btn-dark btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#ajoutEvent" title="Ajouter un Evènement"><i class="fas fa-plus"></i></button>
                </div>
            </div>

            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th scope="col">Edition / Titre</th>
                        <th scope="col">Date / Heure</th>
                        <th scope="col">Lieu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($eventsList as $event) : ?>
                        <tr style="background-color: <?= $event->color ?>;">
                            <td>
                                <a href="" class="btn btn-outline-dark btn-xs mx-2" data-bs-toggle="modal" data-bs-target="#modifyEvent" data-bs-idModify="<?= $event->id ?>" data-bs-subjectModify="<?= $event->title ?>" data-bs-descriptionModify="<?= $event->description ?>" data-bs-locationModify="<?= $event->location ?>" data-bs-dateModify="<?= strftime('%x', strtotime($event->date)) ?>" data-bs-hourModify="<?= strftime('%R', strtotime($event->date)) ?>">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <?= $event->title; ?>
                            </td>
                            <td><?= strftime('%x %R', strtotime($event->date)) ?></td>
                            <td><?= $event->location; ?></td>
                        </tr>
                        <tr style="background-color: <?= $event->color ?>;">
                            <td colspan="3">
                                <span class="ms-5 fw-bold">Description:</span> <?= $event->description; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal ajout d'un évènement -->
    <div class="modal fade" id="ajoutEvent" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="/Events/addEvents" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un évènement.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="honeyPot">
                    <input type="text" class="form-control form-control-sm text-dark bg-light" name="title" placeholder="Type d'évènement" required>
                    <input type="text" class="form-control form-control-sm text-dark bg-light my-2" name="location" placeholder="Lieu" required>
                    <input type="text" class="form-control form-control-sm text-dark bg-light" name="date" placeholder="Date (jj/mm/AAAA)" pattern="^(?:(?:31(\/)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/)(?:0?[13-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$" required>
                    <input type="text" class="form-control form-control-sm text-dark bg-light my-2" name="hour" placeholder="Heure (hh:mm)" pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" required>
                    <textarea class="form-control form-control-sm text-dark bg-light noresize" rows="5" name="description" placeholder="Description"></textarea>
                    <select class="form-select form-select-sm text-dark bg-light my-2" aria-label="Default select example" name="color">
                        <option selected>Couleur de fond :</option>
                        <option class="bg-blanc" value="#FFFFFF">Blanc (défaut)</option>
                        <option class="bg-bleu" value="#9AEDFF">Bleu</option>
                        <option class="bg-gris" value="#BBBBBB">Gris</option>
                        <option class="bg-jaune" value="#FFFFAC">Jaune</option>
                        <option class="bg-rouge" value="#FFAC9A">Rouge</option>
                        <option class="bg-rose" value="#F2B0EC">Rose</option>
                        <option class="bg-vert" value="#B0F2B6">Vert</option>
                        <option class="bg-violet" value="#ACACFF">Violet</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary btn-sm">Valider</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de modification d'un évènement -->
    <div class="modal fade" id="modifyEvent" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="/Events/modifyEvents" method="POST" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modification de l'évènement.</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <input type="hidden" name="honeyPot">
                    </div>
                    <div class="modal-body">
                        <div class="modal-body0">
                            <input type="text" class="form-control form-control-sm text-dark bg-light" placeholder="Titre" name="title" required>
                        </div>
                        <div class="modal-body1">
                            <input type="text" class="form-control form-control-sm text-dark bg-light my-2" placeholder="Lieu" name="location" required>
                        </div>
                        <div class="modal-body2">
                            <input type="text" class="form-control form-control-sm text-dark bg-light" placeholder="Date (jj/mm/AAAA)" pattern="^(?:(?:31(\/)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/)(?:0?[13-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$" name="date" required>
                        </div>
                        <div class="modal-body3">
                            <input type="text" class="form-control form-control-sm text-dark bg-light my-2" placeholder="Heure (hh:mm)" name="hour" pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" required>
                        </div>
                        <div class="modal-body4">
                            <textarea class="form-control form-control-sm text-dark bg-light noresize" rows="5" placeholder="Description" name="description" required></textarea>
                        </div>
                        <select class="form-select form-select-sm text-dark bg-light my-2" aria-label="Default select example" name="color">
                            <option selected>Couleur de fond :</option>
                            <option class="bg-blanc" value="#FFFFFF">Blanc (défaut)</option>
                            <option class="bg-bleu" value="#9AEDFF">Bleu</option>
                            <option class="bg-gris" value="#BBBBBB">Gris</option>
                            <option class="bg-jaune" value="#FFFFAC">Jaune</option>
                            <option class="bg-rouge" value="#FFAC9A">Rouge</option>
                            <option class="bg-rose" value="#F2B0EC">Rose</option>
                            <option class="bg-vert" value="#B0F2B6">Vert</option>
                            <option class="bg-violet" value="#ACACFF">Violet</option>
                        </select>
                        <div class="modal-body5">
                            <input type="hidden" class="form-control form-control-sm text-dark bg-light my-2" name="id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary btn-sm">Modifier</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </form>
                <form action="/Events/deleteEvents" method="POST">
                    <div class="modal-body6">
                        <input type="hidden" name="deleteIdEvent">
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="honeyPot">
                        <input type="checkbox" class="form-check-input" id="deleteCheck" name="deleteCheck" required>
                        <label class="form-check-label" for="deleteCheck">Supprimer l'évènement</label>
                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>