<div id="contenu">
    <form name="frmConsultFrais" method="POST"
          action="index.php?choixTraitement=tablette&action=ValidAppelQRCode">
        <fieldset>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">Présences par QR-Code</h4>

                            <input id="qrcode" type="text" class="form-control" name="qrcode" autofocus
                                   placeholder="Scanner le QR-Code pour faire l'appel">

                            <input value="Ajouter la présence" type="submit" class="mt-3 btn btn-lg btn-success w-100">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>

<script type="text/javascript" src="./vues/tablette/tablette.js"></script>

<script>
    const input = $('#qrcode');
    const form = $(document.forms['frmConsultFrais']);

    let qrCode = '';
    let hasShift = false;

    /**
     * @param e {KeyboardEvent}
     */
    function keydown(e) {
        e.preventDefault();

        if (['e', 'i'].includes(e.key) && qrCode === '')
            qrCode = e.key;
        else if (e.key === 'Shift' && qrCode.length === 1)
            hasShift = true;
        else if ((hasShift && e.code === 'Minus') || (['e', 'i'].includes(qrCode) && e.key === '_')) {
            qrCode += '_';
            hasShift = false;
        }
        else if (e.code.startsWith('Digit') && qrCode.length >= 2)
            qrCode += e.code.substring(5);
        else if (e.code.startsWith('Numpad') && qrCode.length >= 2)
            qrCode += e.code.substring(6);
        else if (e.code === 'Backspace')
            qrCode = qrCode.substring(0, qrCode.length - 1);
        else if (e.key === 'Enter' || e.code === 'NumpadEnter') {
            input.val(qrCode);
            form.submit();
        }

        input.val(qrCode);
    }

    input.on('keydown', keydown);
    form.on('submit', async e => {
        e.preventDefault();

        const data = new FormData();
        data.set('qrcode', input.val());

        const response = await fetch(form.attr('action'), {
            method: 'POST',
            body: data
        });
        const msg = await response.json();

        if (response.status === 200)
            alert('Presence ajoutée');
        else if (response.status === 404)
            alert(`[ERREUR] Personne inexistante (QR-Code ${msg['qrcode']})`);
        else alert(`[ERREUR] ${msg['erreur']}`);
        document.location.reload();
    });
</script>
