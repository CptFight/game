
<section class="l-annonces-search l-annonces-section apparitionright">
    <!-- TODO ME : AJOUTER VERIFICATION FORM + LABELS -->
    <form action="" method="POST">
    <div class="l-annonces-form l-form">
        <fieldset class="inputstyle">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
        </fieldset>
        <fieldset class="inputstyle">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </fieldset>
        <fieldset class="inputstyle">
            <label for="message">Place your message</label>
            <textarea required id="message" name="message"></textarea>
        </fieldset>
        <fieldset class="radio-inline-cont ">
            <div>
                <input name="lang" type="radio" value="FR/NL" id="FR/NL">
                <label for="FR/NL">FR/NL</label>
            </div><!--
             --><div>
                <input name="lang" type="radio" value="FR" id="FR">
                <label for="FR">FR</label>
            </div><!--
             --><div>
                <input name="lang" type="radio" value="NL" id="NL">
                <label for="NL">NL</label>
            </div>
        </fieldset>
        <fieldset class="checkbox-inline-cont ">
            <div>
                <input name="langues" type="checkbox" value="FR/NLb" checked id="FR/NLb">
                <label for="FR/NLb">FR/NL</label>
            </div><!--
             --><div>
                <input name="langues" type="checkbox" value="FRb" id="FRb" >
                <label for="FRb">FR</label>
            </div><!--
             --><div>
                <input name="langues" type="checkbox" value="NLb" id="NLb">
                <label for="NLb">NL</label>
            </div>
        </fieldset>
        <fieldset>
            <button name="submit" class="btn" type="submit">Submit</button>
        </fieldset>
    </div>
</form>
    <!--<a href="" class="btn">Charger plus d'annonces</a>-->
</section>
