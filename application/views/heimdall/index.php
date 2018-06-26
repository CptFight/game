
<section class="apparitionright l-news-section">
    <ul class="m-news-list">

        <?foreach($convers as $key => $message){ ?>
        <li>
            <article>
                <div>
                    <h3><?php echo $message['char']; ?></h3>
                    <p><?php echo $message['message']; ?></p>
                </div>
            </article>
        </li>
        <?php } ?>
        
    </ul>
</section>
           
