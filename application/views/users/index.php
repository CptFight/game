
<section class="l-annonces-search l-annonces-section apparitionright">
    <div class="clearfix l-top-annonces-export">
       <div class="btns-calendar">
            <a href="<?php echo site_url('users/news'); ?>"><?php echo $this->lang->line('new'); ?></a> 
            <a class="active" href="<?php echo site_url('users/index'); ?>"><?php echo $this->lang->line('liste'); ?></a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" data-page-size="50" id="liste_table">
            <thead>
                <tr>
                    <th ><?php echo $this->lang->line('name'); ?></th>
                    <th ><?php echo $this->lang->line('agence'); ?></th>
                    <th ><?php echo $this->lang->line('role'); ?></th>
                    <th ><?php echo $this->lang->line('email'); ?></th>
                    <th ><?php echo $this->lang->line('created_at'); ?></th>
                    <th ><?php echo $this->lang->line('last_connection'); ?></th>
                    <th ><?php echo $this->lang->line('active'); ?></th>
                    <th class="desktop"><?php echo $this->lang->line('actions'); ?></th>
                </tr>
            </thead>

            <tbody>
            
            </tbody>

          
        </table>
    </div>
   
</section>
           
