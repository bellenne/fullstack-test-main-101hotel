<div class="d-flex mt-2 flex-column w-100 mb-2">
            <?php
                foreach ($comments as $comment) {
                    ?>
                        <div class="container comment border-bottom pt-2">
                            <div class="d-flex flex-column">
                                <div class="row ">
                                    <h4 class="col">#<?=$comment["id"]?></h4>
                                    <span class="date col"><?=$comment["date"]?></span>
                                    </div>
                                <h3 class="user-info"><?=$comment["name"]?></h3>
                            </div>
                            <p class="comment-text"><?=$comment["text"]?></p>
                            <div class="row mt-2 mb-2">
                                <div class="col">
                                    <input type="button" data-id="<?=$comment["id"]?>" class="btn btn-outline-danger removeComment" value="Remove comment"></input>
                                </div>
                            </div>
                        </div>
                    <?php
                }
            ?>
</div>
<div class="d-flex justify-content-center">
    <?=$pager->links()?>
</div>