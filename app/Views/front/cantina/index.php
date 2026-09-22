<div class="row">
    <div class="col d-flex">
        <div>
            <h1 class="shadow text-white">La Cantina</h1>
            <span class="text-white">Ici, on recrute nos mercenaires</span>
        </div>

        <div class="ms-auto d-flex align-items-center">
            <span class="me-3 fs-1" id="timer" data-seconds="<?= $remaining_seconds; ?>">
                <?= $remaining_time; ?>
            </span>

            <?= form_open('cantina/refresh'); ?>
            <button type="submit" class="btn btn-kaosmik">
                Rafraîchir
                <i class="fa-solid fa-cent-sign ms-2"></i>
                <span id="refresh-cost"></span>
            </button>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<div class="row g-3">
    <?php foreach ($cantinaHeroes as $hero) : ?>
        <div class="col">
            <?= view_cell('HeroCell', [
                    'character' => $hero,
                    'context' => 'cantina'
            ]); ?>
        </div>
    <?php endforeach; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Sélection des éléments
        const timerElement = document.getElementById('timer');
        const refreshCostElement = document.getElementById('refresh-cost');
        if (!timerElement) {
            return;
        }
        // Récupération des secondes
        let remainingSeconds = parseInt(
            timerElement.dataset.seconds,
            10
        );
        // Sécurité : si invalide ou 0, on rafraîchit
        if (isNaN(remainingSeconds) || remainingSeconds <= 0) {
            window.location.reload();
            return;
        }
        // Conversion des secondes en HH:MM:SS
        const formatTime = (seconds) => {
            const h = Math.floor(seconds / 3600);
            const m = Math.floor((seconds % 3600) / 60);
            const s = seconds % 60;
            const pad = (num) => String(num).padStart(2, '0');
            return `${pad(h)}:${pad(m)}:${pad(s)}`;
        };

        // Calcul du coût de rafraîchissement
        const updateRefreshCost = (seconds) => {
            if (!refreshCostElement) {
                return;
            }
            const h = Math.floor(seconds / 3600);
            const cost = (h + 1) * 10;
            refreshCostElement.textContent = cost;
        };

        // Affichage initial
        timerElement.textContent = formatTime(remainingSeconds);
        updateRefreshCost(remainingSeconds);

        // Création du décompte
        const countdown = setInterval(() => {
            remainingSeconds--;

            if (remainingSeconds <= 0) {
                clearInterval(countdown);
                timerElement.textContent = "00:00:00";
                // Recharge la page pour générer les nouvelles offres
                window.location.reload();
                return;
            }

            // Mise à jour du compteur
            timerElement.textContent = formatTime(remainingSeconds);
            // Mettre à jour le coût quand on change d'heure
            if (remainingSeconds % 3600 === 3599) {
                updateRefreshCost(remainingSeconds);
            }

        }, 1000);


        // Confirmation lors de la suppression d'un élément
        $(document).on('submit', 'form[action*="delete"]', function(e) {
            e.preventDefault();
            let form = $(this);

            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: 'Cette action est irréversible !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {

                if (result.isConfirmed) {
                    form.get(0).submit();
                }
            });
        });
    });
</script>
