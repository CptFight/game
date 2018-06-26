<head>
    <meta name="viewport" content="width=device-width" />
    <title><?php echo $this->lang->line('mail_subscribers_title'); ?> </title>
</head>

<body>

<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" width="600">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="alert alert-good">
                            <?php echo sprintf($this->lang->line('mail_subscribers_message'),count($annonces) ); ?> 
                        </td>
                    </tr>
                    <tr>
                        <td class="content-wrap">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="content-block">
                                        <ul>
                                        <?php 
                                        if(!$subscriber->search_price_min) $search_price_min = '';
                                        else $search_price_min = $subscriber->search_price_min;
                                        if(!$subscriber->search_price_max) $search_price_max = '';
                                        else $search_price_max = $subscriber->search_price_max;
                                        ?>
                                            <li><?php echo $this->lang->line('province') ; ?>  : 
                                            <?php 
                                            $search_provinces = json_decode($subscriber->search_provinces);
                                            foreach($search_provinces as $key => $province){
                                                echo $province." ,";
                                            }
                                            ?>
                                            </li>
                                           <li><?php echo $this->lang->line('min_price') ; ?>  : <?php echo $search_price_min; ?></li>
                                            <li><?php echo $this->lang->line('max_price') ; ?>  : <?php echo $search_price_max; ?></li>
                                            <li><?php echo $this->lang->line('zip_codes') ; ?>  : <?php echo $subscriber->search_zipcodes; ?></li>
                                            <li><?php echo $this->lang->line('lang_word') ; ?> : <?php echo $subscriber->search_lang; ?></li>
                                            <?php 
                                            if($subscriber->search_sell){
                                                $vente = $this->lang->line('sell');
                                            }else{
                                                $vente = $this->lang->line('location');
                                            }
                                            ?>
                                            <li><?php echo $this->lang->line('sell') ; ?> : <?php echo $vente; ?></li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="invoice-items" cellpadding="0" cellspacing="0">
                                            <?php foreach($annonces as $key => $annonce){ ?>
                                                <tr><td><a href="<?php echo $annonce->url; ?>"><?php echo $annonce->title; ?></a></td></tr>
                                                <tr><td>&nbsp;</td></tr>
                                            <?php } ?>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="footer">
                    <table width="100%">
                        <tr>
                            <td class="aligncenter content-block">From <a href="<?php echo $host; ?>">@Immoffice</a> .</td>
                        </tr>
                    </table>
                </div></div>
        </td>
        <td></td>
    </tr>
</table>

</body>

