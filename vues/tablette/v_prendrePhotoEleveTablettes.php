<div id="contenu">
    <form name="frmConsultFrais" method="POST"
          action="index.php?choixTraitement=tablette&action=ChangerPhotoEleve">
        <fieldset>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">
                                <?= $type ?> de la photo de <?= $eleve['NOM'] ?> <?= $eleve['PRENOM'] ?>
                            </h4>

                            <div id="div-picture-preview" class="row">
                                <div class="col-lg-6">
                                    <canvas id="canvas-video"></canvas>
                                </div>
                                <div class="col-lg-6">
                                    <canvas id="canvas-preview" height="0"></canvas>
                                </div>
                            </div>

                            <div id="div-take-picture">
                                <button type="button" id="take-picture" class="btn btn-lg btn-outline-primary w-50 disabled">
                                    Prendre la photo
                                </button>
                                <button type="button" id="save-picture" class="btn btn-lg btn-outline-success w-50 disabled">
                                    Envoyer la photo
                                </button>
                            </div>

                            <!--<input value="Soumettre" type="submit" class="mt-4 btn btn-lg btn-success w-100">-->
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>

<script type="text/javascript" src="./vendors/select2/dist/js/select2.min.js"></script>

<!-- custome.js -->
<script type="text/javascript" src="./js/form-components/input-select.js"></script>
<script type="text/javascript" src="./vues/tablette/tablette.js"></script>

<script>
    $(document).ready(() => {
        const video = document.createElement('video');
        const canvasVideoElmt = document.getElementById('canvas-video');
        const canvasVideoCtx = canvasVideoElmt.getContext('2d');

        const canvasPreviewElmt = document.getElementById('canvas-preview');
        const canvasPreviewCtx = canvasPreviewElmt.getContext('2d');

        const takePictureBtn = $('#take-picture');
        const savePictureBtn = $('#save-picture');

        takePictureBtn.on('click', e => {
            e.preventDefault();

            const {height, width} = canvasVideoElmt;
            canvasPreviewElmt.height = height;
            canvasPreviewElmt.width = width;
            canvasPreviewCtx.drawImage(video, 0, 0, width, height);

            savePictureBtn.removeClass('disabled');
        });
        savePictureBtn.on('click', e => {
            e.preventDefault();

            const formData = new FormData();
            formData.set('idEleve', <?= $eleve['ID_ELEVE'] ?>);
            formData.set('photo', canvasPreviewElmt.toDataURL('image/jpeg'));

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'index.php?choixTraitement=tablette&action=ChangerPhotoEleve');
            xhr.onload = () => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert('Photo envoyée avec succès !');
                    const search = new URLSearchParams(window.location.search);
                    search.set('choixTraitement', 'tablette');
                    search.set('action', 'appelEleves');
                    window.location.search = search.toString();
                }
            };
            xhr.send(formData);
        });

        const showVideo = () => {
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                canvasVideoElmt.height = video.videoHeight;
                canvasVideoElmt.width = video.videoWidth;
                canvasVideoCtx.drawImage(video, 0, 0, canvasVideoElmt.width, canvasVideoElmt.height);
            }
            requestAnimationFrame(showVideo);
        };

        /*=== FIX BY https://developer.mozilla.org/fr/docs/Web/API/MediaDevices/getUserMedia#utilisation_de_la_nouvelle_api_dans_les_navigateurs_plus_anciens ===*/
        // Older browsers might not implement mediaDevices at all, so we set an empty object first
        if (navigator.mediaDevices === undefined) {
            navigator.mediaDevices = {};
        }

        // Some browsers partially implement mediaDevices. We can't just assign an object
        // with getUserMedia as it would overwrite existing properties.
        // Here, we will just add the getUserMedia property if it's missing.
        if (navigator.mediaDevices.getUserMedia === undefined) {
            navigator.mediaDevices.getUserMedia = function(constraints) {

                // First get ahold of the legacy getUserMedia, if present
                var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

                // Some browsers just don't implement it - return a rejected promise with an error
                // to keep a consistent interface
                if (!getUserMedia) {
                    return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
                }

                // Otherwise, wrap the call to the old navigator.getUserMedia with a Promise
                return new Promise(function(resolve, reject) {
                    getUserMedia.call(navigator, constraints, resolve, reject);
                });
            }
        }
        /*=== END FIX ===*/

        navigator.mediaDevices.getUserMedia({video: {facingMode: 'environment'}})
            .then(stream => {
                takePictureBtn.removeClass('disabled');

                video.srcObject = stream;
                video.setAttribute('playsinline', true); // required to tell iOS safari we don't want fullscreen
                video.play();

                requestAnimationFrame(showVideo);
            })
            .catch(() => alert('Impossible d\'utiliser la caméra de l\'appareil'));
    });
</script>
