<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = $page->title;
$this->params['breadcrumbs'][] = $page->title;
?>
<section id="user-page">
    <section class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1><?= Html::encode($page->title) ?></h1>
                <?if($page->id == 2):?>
                    <div class="row">
                        <?foreach ($page->teams as $team):?>

                            <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12">
                                    <div class="shown text-center wow fadeInUp" data-toggle="modal" data-target="#teamModal<?= $team->id?>" >
                                        <div class="team-container post-13532 dt_team type-dt_team status-publish has-post-thumbnail hentry description-off">
                                            <div class="team-media">
                                                <div href="" class="rollover this-ready">
                                                    <?= Html::img($team->image ? '/uploads/teams/120-120/'.$team->image : '/images/default.jpg', ['alt' => 'image', 'class' => 'round-image iso-layzr-loaded'])?>
                                                    <i class="cover-color"></i>
                                                </div>
                                            </div>
                                            <div class="team-desc">
                                                <div class="team-author">
                                                    <div class="team-author-name"><?= $team->full_name?></div>
                                                    <p class="team-position"> <?= $team->type?></p>
                                                    <p class="vew-more">Vew More <i class="fa fa-angle-right"></i></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- Modal -->
                            <div class="modal fade" id="teamModal<?= $team->id?>" tabindex="-1" role="dialog" aria-labelledby="teamModalLabel<?= $team->id?>">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header team-modal-header">
                                            <div class="modal-icon team-icon"><img src="/images/ico.png"></div>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <div class="mt-avatar-team">
                                                <?= Html::img($team->image ? '/uploads/teams/120-120/'.$team->image : '/images/default.jpg', ['alt' => 'image', 'class' => 'round-image iso-layzr-loaded'])?>
                                            </div>
                                            <div class="team-author-popup">
                                                <div class="team-author-name"><?= $team->full_name?></div>
                                                <p class="team-position"> <?= $team->type?></p>
                                            </div>
                                        </div>
                                        <div class="modal-body team-modal-body">
                                            <div class="team-content">
                                                <p>
                                                    <?= $team->description?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="modal-footer team-modal-footer">
                                            <button type="button" class="btn btn-blue" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?endforeach;?>
                    </div>
                <?else:?>
                    <div><?= $page->description?></div>
                <?endif;?>
            </div>
        </div>

    </section>
</section>