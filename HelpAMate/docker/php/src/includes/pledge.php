<?php
echo <<<HTML
<script>
    $(document).ready(function(){
        if($('#pledge').css('display') == 'none') {
            $('input[value=5]').prop('checked', true);
        }
            
        $("input[type=radio]").change(function(){
            $("#othertext").hide();
            $('#othertext').val('');
        });
        $("input[id=other]").change(function(){
            $("#othertext").show();
        });
    });
</script>

<div class="display-box pledge">
    <form method="post" action="process_pledge.php" >
        <div class="form">
            <span class="close pledge" onclick='toggleHide(this)'>&#xD7;</span>
            <h2>Pledge</h2>
HTML;

if (isset($_SESSION['pledgeError'])) { echo "<span id='{$_SESSION['pledgeError']}</span>"; }

echo <<<HTML
            <input type="email" required name="DonorEmail"   title="Email format: example@example.com"
                placeholder="Email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
            <input type="text" required name="DisplayName" title="2 to 10 characters" placeholder="Display Name"
                pattern=".{2,15}">
            
            <span>
                <label class="container">
                    <input type="radio" checked="checked" name="radio" value="5">
                    <span class="checkmark">$5</span>
                </label>
                <label class="container">
                    <input type="radio" name="radio" value="20">
                    <span class="checkmark">$20</span>
                </label>
                <label class="container">
                    <input type="radio" name="radio" value="50">
                    <span class="checkmark">$50</span>
                </label>
                <label class="container">
                    <input type="radio" id='other' name="radio">
                    <span class="checkmark">Other</span>
                </label>
            </span>
            
            <div class="flex" id="othertext" style="display:none;"> <!-- https://www.youtube.com/watch?v=Uu8_7XhRzV0 -->
                <span class="currency">$</span>
HTML;

if (isset($user['other'])) {
    echo "<input type='number' id='other' name='other' placeholder='100' max='100' min='5' value='$user[other]'>\n";
} else {
    echo "<input type='number' id='other' name='other' placeholder='100' max='100' min='5'>\n";
}

echo <<<HTML
            </div>
            <input type="submit" name="submit" value="Pledge" class="submit">
            
        </div>
    </form>
</div>
HTML;
