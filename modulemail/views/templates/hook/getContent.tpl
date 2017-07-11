{if isset($confirmation)}
<div class="alert alert-success">
La configuration a bien été mise à jour
</div>
{/if}
<form method="post" action="" class="defaultForm form-horizontal">
<div class="panel">
  <div class="panel-heading">
    <i class="icon-cogs"></i>
    Configuration
  </div>
  <div class="form-group">
    <label class="control-label"><B/>Recevoir un mail lorsque le stock d'un produit est modifié :</B></label><p></p>
    <div class="form">
      <img src="../img/admin/enabled.gif" alt="" />
      <input type="radio" id="enable_mail_1" name="enable_mail" value="1"
      {if $enable_mail eq '1'}checked{/if} />
      <label class="t" for="enable_mail_1">Oui&nbsp;&nbsp;</label>
      <img src="../img/admin/disabled.gif" alt="" />
      <input type="radio" id="enable_mail_0" name="enable_mail" value="0"
      {if $enable_mail ne '1'}checked{/if} />
      <label class="t" for="enable_mail_0">Non</label>
      <br></br>
      <div class="from-group">
        <label for="mail"><B>Email :</B></label><p></p>
        <input type="email" placeholder="E-mail" id="mail" name="mail" size="30"
        value={if $mail ne 'NULL'}{$mail}{/if} />
      </div>
    </div>
  </div>
  <div class="panel-footer">
    <button class="btn btn-default pull-right" name="submit_config"
    value="1" type="submit">
      <i class="process-icon-save"></i> Enregistrer
    </button>
  </div>
</div>
</form>
