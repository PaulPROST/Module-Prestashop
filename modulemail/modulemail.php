<?php
if (!defined('_PS_VERSION_'))
  exit;

class ModuleMail extends Module
{
  protected $isSaved = false;
  public function __construct()
  {
    $this->name = 'modulemail';
    $this->tab = 'administration';
    $this->version = '1.0.0';
    $this->author = 'Paul Prost';
    $this->need_instance = 0;
    $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    $this->bootstrap = true;
    parent::__construct();
    $this->displayName = $this->l('Module Mail Stock');
    $this->description = $this->l("Envoie par e-mail automatiquement la quantité de produits restants en stock à chaque fois que le stock d'un produit est modifié.");
    $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    if (!Configuration::get('MODULEMAIL_NAME'))
      $this->warning = $this->l('No name provided');
  }

  public function install()
  {
    if (parent::install() == false)
      return false;
    $this->registerHook('actionUpdateQuantity');
    return true;
  }

  public function uninstall()
  {
    return parent::uninstall() && Configuration::deleteByName('MYMODULE_NAME');
  }

  public function assignConfiguration()
  {
    $enable_mail = Configuration::get('EMAIL_VALUE');
    $mail = Configuration::get('MOD_EMAIL');
    $this->context->smarty->assign('enable_mail', $enable_mail);
    $this->context->smarty->assign('mail', $mail);
  }

  public function processConfiguration()
  {
    if (Tools::isSubmit('submit_config'))
    {
      $enable_mail = Tools::getValue('enable_mail');
      $mail = Tools::getValue('mail');
      Configuration::updateValue('EMAIL_VALUE', $enable_mail);
      Configuration::updateValue('MOD_EMAIL', $mail);
      $this->context->smarty->assign('confirmation', 'ok');
    }
  }

  public function getContent()
  {
    $this->processConfiguration();
    $this->assignConfiguration();
    return $this->display(__FILE__, 'getContent.tpl');
  }

    public function hookActionUpdateQuantity($params)
    {
      if (Configuration::get('EMAIL_VALUE') == 1 && $this->isSaved == false)
      {
        $id_product = (int) $params['id_product'];
        $id_shop = (int) $context->shop->id;
        $name = ProductCore::getProductName($id_product, null, null);
        $quantity = (int) $params['quantity'];
        $to = Configuration::get('MOD_EMAIL');
        $subject = 'Boutique '.Configuration::get('PS_SHOP_NAME').' modification de stock produit ID: '.$id_product;
        $message = "Bonjour,\r\n\nSuite à une modification de stock, il ne reste plus que ".$quantity." articles pour le produit :"
        ."\n\n".$name.
        "\nID   : ".$id_product.
        "\n\nPrestashop.";
        mail($to, $subject, $message, $headers);
        $this->isSaved = true;
      }
  }
}
?>
