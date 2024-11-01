<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

function woocominfusnintrgn_add_option()
{
    add_menu_page("Setting Page", "WooInfusion", "manage_options", "wooinfusions-settings-option", "woacrtsetting_page", null, 99);
}
function woacrtsetting_page()
{
    ?>
        <div class="wrap">
        <h1>Please Enter your infusionsoft app url and api key</h1><br>
            
        <form method="post" action="options.php">
            <?php
                settings_fields("section");
                do_settings_sections("theme-options");  
                submit_button();
            ?>      
        </form>
        </div>
    <?php
}

function woocominfusnintrgn_your_url()
{
    ?>
        <input type="text" name="woacrturl" id="woacrturl" value="<?php echo get_option('woacrturl'); ?>" /> <br>
<i>Infusionsoft url will be similar to xxxxx.infusionsoft.com (you will need to replace xxxxx with your infusionsoft app name). </i> <br>
            <b><i>note: never use http:// or https:// before the infusionsoft app url. <a href="http://marketingautomationexpert24.com/wp-content/uploads/2017/05/infusionsoft-app-url.png">Lets see an example here . </a> </i> </b>
            <br> 
    <?php
}

function woocominfusnintrgn_api()
{
    ?>
        <input type="text" name="woacrtapikey" id="woacrtapikey" value="<?php echo get_option('woacrtapikey'); ?>" /> <br>
<i>You can find your infusiosnfot api key by going Admin-> Setting -> Application . And then you will need copy the Encrypted Key. if there is no Encrypted Key found, you will need to enter a random text in  API Passphrase field and then click save and it will then generate the Encrypted Key (known as api key). <b> lets check these : <a href="http://marketingautomationexpert24.com/wp-content/uploads/2017/05/api-key-step-1.png">step 1</a> and <a href="http://marketingautomationexpert24.com/wp-content/uploads/2017/05/api-key-step-2-3.png">step 2 .</a> </b></i>
    <?php
}

function woocominfusnintrgn_tagging()
{
    ?>
        <input type="text" name="tagname" id="tagname" value="<?php echo get_option('tagname'); ?>" /> <br> <i>Upon successful purchase in woocommerce, this tag will be applied to the customer. You will just need the id number of the specific tag and that tag will be automatically added to the contact record in infusionsoft. <b> lets check these : <a href="http://marketingautomationexpert24.com/wp-content/uploads/2017/05/tag-step-1.png">step 1</a> ,  <a href="http://marketingautomationexpert24.com/wp-content/uploads/2017/05/tag-step-2.png">step 2 </a> and <a href="http://marketingautomationexpert24.com/wp-content/uploads/2017/05/tag-step-3.png">step 3 .</a></b></i>
    
    <?php
}

function woocominfusnintrgn_panel_fields()
{
    add_settings_section("section", "All Settings", null, "theme-options");
 
    add_settings_field("woacrturl", "URL", "woocominfusnintrgn_your_url", "theme-options", "section");
    add_settings_field("woacrtapikey", "API KEY", "woocominfusnintrgn_api", "theme-options", "section");
add_settings_field("tagname", "Tag id", "woocominfusnintrgn_tagging", "theme-options", "section");

    register_setting("section", "woacrturl");
    register_setting("section", "woacrtapikey");
  register_setting("section", "tagname");
}


function woocominfusnintrgn_order_ext( $order_id ){
    // get order object and order details
    $order = new WC_Order( $order_id );
    $email12 = $order->billing_email;
    $firstname12 = $order->billing_first_name;
    $lastname12= $order->billing_last_name;
    $phone1 = $order->billing_phone;
    $shipping_type = $order->get_shipping_method();
    $shipping_cost = $order->get_total_shipping();
$items = $order->get_items();
foreach ( $items as $item ) {
    $product_name = $item['name'];
    $product_id = $item['product_id'];
    $product_variation_id = $item['variation_id'];

$contacts = Infusionsoft_DataService::query(new Infusionsoft_Contact(), array('Email' => $email12));
$contact = array_shift($contacts);

if (isset($contact->Id)){
    $tagid1=get_option('tagname');
Infusionsoft_ContactService::addToGroup($contact->Id,$tagid1);

    
$optin = new Infusionsoft_EmailService();
        $optin->optIn( $email12, 'provided information');   
    
    
}
else {
$contact = new Infusionsoft_Contact();
$contact->FirstName = $firstname12;
$contact->LastName =  $lastname12;
$contact->Email =  $email12;
$contact->save();

    
$myid=$contact->Id;
$tagid1=get_option('tagname');
Infusionsoft_ContactService::addToGroup($myid, $tagid1);

        $optin = new Infusionsoft_EmailService();
        $optin->optIn( $email12, 'provided information');


}
}


}





