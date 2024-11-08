<!-- Modal -->
<div class="modal fade" id="call-me" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Je veux être appellé par un conseiller client</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6 mb15">
            <div class="help-widget">
              <h5>Besoin d'aide ?</h5>
              <p>Faite vous appeller dans un delais d'une heure par l'un de nos conseillers clients.</p>
              <a href="#" class="btn btn-primary btn-white get-in-touch" data-text="FAQ"><i class="fa fa-question"></i>FAQ</a>
            </div>
            
            <a href="#." class="company-presentation-link" style="color:#fff"><i class="fa fa-phone"></i> ou appelez au (+225) 220 170 00</a>
          </div>
          <div class="col-md-6" >
            <div class="form">
              <p class="alert alert-success" id="call_success" style="display:none;"> Votre requête à été soumise. Un conseillé client vous contactera dans un délai d'une heure</p>
              <p class="alert alert-danger" id="call_error" style="display:none;">Une erreur s'est produite contacter nous au 21-21-21-21</p>
              <p class="alert alert-info" id="call_info" style="display:none;">Aucun de nos conseiller client n'est disponible pour l'instant</p>
              <p class="alert alert-warning" id="call_off" style="display:none;">Votre première demande d'appel est en cours de traitement. Un conseiller client vous contactera très bientôt!</p>
              <form  method="post" action="{{route('callme')}}" id="callMeForm">

                {{csrf_field()}}
                <input type="text" data-delay="300" required placeholder="Votre nom" name="call_name" id="call_name" class="input" >
                <input type="text" data-delay="300" required placeholder="Votre numéro de téléphone" name="call_phone" id="call_phone" class="input call-me phone-ci" >
                <div class="styled-select">
                  <select class="" name="call_motif" required>
                    <option>Quel est le motif de votre appel ?</option>
                    <option value="1">Renouvelement de police</option>
                    <option value="2">Nouveau devis</option>
                    <option value="3">Demande d'information</option>
                  </select>
                </div>
                <br/>
                <br/>
                <button class="btn btn-primary" name="call" type="submit" data-text="Valider" onClick="">Valider</button> <img src="/images/loader.gif" id="callLoader" style="display:none">
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-text="Quitter" data-dismiss="modal">Quitter</button>
    </div>
  </div>
</div>
