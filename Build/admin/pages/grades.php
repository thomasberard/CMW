<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h2 class="h2 gray">
		Gestion des grades du site
	</h2>
</div>
<?php if(!$_Permission_->verifPerm("createur"))
{
	echo '
	<div class="row">
		<div class="col-md-12 text-center">
			<div class="alert alert-danger">
				<strong>Vous avez aucune permission pour accéder aux réglages des grades.</strong>
			</div>
		</div>
	</div>';
}
else
	{
		?>
    <div class="alert alert-success">
   		<strong>Vous pouvez ajouter autant de grades que vous le souhaitez pour votre site. Grâce à une toute nouvelle fonctionnalité vous pouvez dorénavant modifier/ajouter des permissions à tous vos grades créés. Cependant, les grades par défaut (Créateur et Joueur) ne peuvent pas être modifiés par sécurité.<br>L'accès à cette fonctionnalité est réservée aux Créateurs.</strong>
    </div>
    <div class="alert alert-warning">
        <strong>ATTENTION<br>Certains hébergeurs bloquent la création automatique des grades.</strong>
     </div>

	 <div class="row">

		<div class="col-md-12 col-xl-6 col-12">
			<div class="card  ">
				<div class="card-header ">
					<h3 class="card-title"><strong>Création d'un grade</strong></h3>
				</div>
				<div class="card-body" id="addGrade">
				<?php if(isset($_GET['gradeCreated']))
			            {
			                echo '<div class="alert alert-success text-center">Grade créé avec succès !</div>';
			            }
			            elseif(isset($_GET['nomGradeLong']))
			            {
			                echo '<div class="alert alert-danger text-center"><strong>Erreur !</strong><br>Le nom du grade entré est trop long !</div>';
			            }
			            elseif(isset($_GET['nomGradeCourt']))
			            {
			                echo '<div class="alert alert-danger text-center"><strong>Erreur !</strong><br>Le nom du grade entré est trop court !</div>';
			            }
			            elseif (isset($_GET['cdgi'])) 
			            {
			                echo '<div class="alert alert-danger text-center"><strong>Erreur Critique!</strong><br>Erreur interne, contacter le support de CraftMyWebsite code d\'erreur : cdgi</div>';
			            }
			            elseif(isset($_GET['cdnti']))
			            {
			                echo '<div class="alert alert-danger text-center"><strong>Erreur Critique!</strong><br>Erreur interne, contacter le support de CraftMyWebsite code d\'erreur : cdnti</div>';
			            }
			            elseif(isset($_GET['gradeNameAlreadyUsed']))
			            {
			                echo '<div class="alert alert-danger text-center"><strong>Erreur !</strong>Le nom du grade existe déjà !</div>';
			            }
			            elseif(isset($_GET['gradeDefaultInexistantRegen']))
			            {
			                echo '<div class="alert alert-danger text-center"><strong>Erreur Critique !</strong>Un fichier interne a été supprimé ! Réessayer l\'opération, en cas d\'échec contacter le support de CraftMyWebsite</div>';
			            }
			            elseif(isset($_GET['conflitGrade']))
			            {
			                echo '<div class="alert alert-danger text-center"><strong>Erreur Critique !</strong>Le ficheir existe déjà !</div>';
			            }
			         ?>

                <label class="control-label">Nom du grade</label>
                <input type="text" maxlength="32" minlength="3" name="gradeName" class="form-control" placeholder="Support" required/>
	            </div>

	            <script>initPost("addGrade", "admin.php?&action=addGrade",null);</script>

	            <div class="card-footer">
	                <div class="row text-center">
	                    <input type="submit" onclick="sendPost('addGrade', null);" class="btn btn-success w-100"
	                        value="Envoyer !" />
	                </div>
	            </div>
	        </div>
	   	</div>

	   	<div class="col-md-12 col-xl-6 col-12">
			<div class="card  ">
				<div class="card-header ">
					<h3 class="card-title"><strong>Édition des grades</strong></h3>
				</div>
				<div class="card-body" id="allGrade">
					<ul class="nav nav-tabs">
						<li class="nav-item"><a href="#gradeCreateur" id="default-name-createur-2" class="nav-link active" style="color: black !important" data-toggle="tab"><?php echo $_Serveur_['General']['createur']['nom']; ?></a></li>
						<?php for($i = 2; $i <= max($lastGrade); $i++) { 
                            if(file_exists($dirGrades.$i.'.yml')) { ?>
                                <li class="nav-item" id="tabgrade<?php echo $i; ?>"><a href="#grade<?php echo $i; ?>" class="nav-link"  id="grade-name-<?php echo $i; ?>" style="color: black !important"  data-toggle="tab"><?php echo $idGrade[$i]['Grade']; ?></a></li>
                            <?php }
                        } ?>
						<li class="nav-item"><a href="#gradeJoueur" id="default-name-joueur-2" class="nav-link"  style="color: black !important" data-toggle="tab"><?php echo $_Serveur_['General']['joueur']; ?></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane well" id="gradeJoueur">
							<div style="width: 100%;display: inline-block">
                                <div class="float-left">
                                    <h3 id="default-name-joueur-1"><?=$_Serveur_['General']['joueur'];?></h3>
                                </div>
                            </div>
	                        <label class="control-label">Nom du grade</label>
	                        <input maxlength="32" minlength="3" onkeyup="get('default-name-joueur-1').innerText = get('default-name-joueur-2').innerText = this.value;" class="form-control" name="nom" type="text" value="<?=$_Serveur_['General']['joueur'];?>" required/>
	                    </div>

	                    <div class="tab-pane active well" id="gradeCreateur">
	                    	<div style="width: 100%;display: inline-block">
                                <div class="float-left">
                                    <h3 id="default-name-createur-1"><?=$_Serveur_['General']['createur']['nom'];?></h3>
                                </div>
                            </div>

                            <label class="control-label">Nom du grade</label>
                            <input maxlength="32" minlength="3" class="form-control" onkeyup="get('default-name-createur-1').innerText = get('default-name-createur-2').innerText = get('grade').innerText = this.value;" name="nomCreateur" type="text"  value="<?=$_Serveur_['General']['createur']['nom'];?>" />

                            <label class="control-label">Couleur du Grade</label>
                            <?php for($a = 0; $a < count($prefixs); $a++) {  ?>
                                <label class="checkbox-inline">
									<input class="form-check-input" type="radio" name="prefixCreateur" value="<?=$prefixs[$a];?>" <?=($_Serveur_['General']['createur']['prefix'] == $prefixs[$a]) ? 'checked' : ''; ?>>
									<span class="prefix <?=$prefixs[$a];?>" style="height: 10px; width: 15px;"></span>
								</label>
                            <?php } ?>
                            <br/>
                            <label class="control-label">Effets</label>
                            <?php for($a =0; $a < count($effets); $a++) { ?>
                                <label class="checkbox-inline">
									<input class="form-check-input" type="radio" name="effetCreateur"  value="<?=$effets[$a];?>"  <?=($_Serveur_['General']['createur']['effets'] == $effets[$a]) ? 'checked' : ''; ?>>
									<span class="username <?=$effets[$a];?>">Test</span>
								</label>
							<?php } ?>
						</div>
						<?php for($i = 2; $i <= max($lastGrade); $i++) { if(file_exists($dirGrades.$i.'.yml')) { ?>
							<div class="tab-pane well" id="grade<?php echo $i; ?>">
								<div style="width: 100%;display: inline-block">
                                    <div class="float-left">
                                        <h3 id="grade-name2-<?php echo $i; ?>"><?php echo $idGrade[$i]['Grade']; ?></h3>
                                    </div>
                                    <div class="float-right">
                                        <button  onclick="sendDirectPost('admin.php?action=supprGrade&id=<?php echo $i; ?>', function(data) { if(data) { hide('grade<?php echo $i; ?>'); hide('tabgrade<?php echo $i; ?>'); } });" class="btn btn-sm btn-outline-secondary">Supprimer</button>
                                    </div>
                                </div>
                                <label class="control-label">Nom du grade</label>
                                <input class="form-control"  onkeyup="get('grade-name2-<?php echo $i; ?>').innerText = get('grade-name-<?php echo $i; ?>').innerText = this.value;" name="gradeName<?php echo $i; ?>" type="text"  value="<?php echo $idGrade[$i]['Grade']; ?>" placeholder="Modérateur"/>

                                <label class="control-label">Couleur du Grade</label>
	                            <?php for($a = 0; $a < count($prefixs); $a++) {  ?>
	                                <label class="checkbox-inline">
										<input class="form-check-input" type="radio" name="prefix<?=$i;?>" value="<?=$prefixs[$a];?>" <?=($idGrade[$i]['prefix'] == $prefixs[$a]) ? 'checked' : ''; ?>>
										<span class="prefix <?=$prefixs[$a];?>" style="height: 10px; width: 15px;"></span>
									</label>
	                            <?php } ?>
	                            <br/>
	                            <label class="control-label">Effets</label>
	                            <?php for($a =0; $a < count($effets); $a++) { ?>
	                                <label class="checkbox-inline">
										<input class="form-check-input" type="radio" name="effet<?=$i;?>"  value="<?=$effets[$a];?>"  <?=($idGrade[$i]['effets'] == $effets[$a]) ? 'checked' : ''; ?>>
										<span class="username <?=$effets[$a];?>">Test</span>
									</label>
								<?php } ?>

								<br/>
								<hr/>
								<div style="width: 100%;display: inline-block">
                                    <div class="float-left">
                                        <h5>Permissions:</h3>
                                    </div>
                                </div>


								<?php $allPerm = $_Permission_->readPerm($i);
								//showForFormatage($allPerm, ""); ne pas toucher ...
								writePerm($allPerm, 20, "", $i, $idGrade, $PermissionFormat); ?>
							</div>
						<?php } } ?>
	                </div>
	            </div>
	            <script>initPost("allGrade", "admin.php?&action=editGrade");</script>

	            <div class="card-footer">
	                <div class="row text-center">
	                    <input type="submit" onclick="sendPost('allGrade');" class="btn btn-success w-100"
	                        value="Valider les changements !" />
	                </div>
	            </div>
	        </div>
	   	</div>

	</div>
<?php } ?>