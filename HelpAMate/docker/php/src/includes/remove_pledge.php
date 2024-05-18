<?php
echo <<<HTML
            <div class="display-box removepledge">
                <form method="post" action="process_remove_pledge.php" >
                    <div class="form">
                        <p>You are trying to remove a pledge, please confirm that you want to remove this pledge.</p>

                        <p>Name: <strong id="pledgeName"></strong></p>
                        <p>Amount: <strong id="pledgeAmount"></strong></p>

                        <input type="hidden" name="pledgeId" id="pledgeId" value="">

                        <span class="removepledge">
                            <span name="submit" class="submit removepledge input" onclick='toggleHide(this)'>
                                Cancel
                            </span>
                            <input name="submit" type="submit" value="Remove" class="delete removepledge">
                        </span>
                    </div>
                </form>
            </div>
        </div>
HTML;
