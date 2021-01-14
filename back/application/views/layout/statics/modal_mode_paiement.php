
<!--MODAL MODE DE PAIEMENT-->
<div class="modal fade" id="modalModePaiement">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center bg-info">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>PAIEMENT</h4>
            </div> 
            
            <div class="modal-body">
            	<div class="row">
            		<div class="col-lg-6">
	            		<div class="form-group">
							<label for="TotalMP">TOTAL</label>
							<div class="input-group">
								<input class="form-control" id="TotalMP" disabled="true" type="text">
								<span class="input-group-addon"><i class="fa fa-check"></i></span>
							</div>
						</div>
            			
            			<div class="form-group">
							<label for="ResteMP">RESTE A PAYER</label>
							<div class="input-group">
								<input class="form-control" id="ResteMP" disabled="true" type="text">
								<span class="input-group-addon"><i class="fa fa-times"></i></span>
							</div>
						</div>	            			

            			<div class="panel panel-success">
							<div class="panel-heading" >
								<h4 class="text-center">MODE DE PAIEMENT</h4>
							</div>
							<div class="panel-body"  style="overflow: auto;height: 200px;">
								<div class="row"> 
								<?php
									foreach ($Mode_Paiement as $data) {
										$selectedModePaiement = ($data->id_mp) == 1 ? "selectedModePaiement" : "" ;
								?>
									<div class="col-lg-6" style="margin-top:4px">
										<?php /* ?><button class="btn btn-lg btn-default btn-block" onclick="Afficher_RR(<?= $data->RR; ?>,<?= '\''.$data->prefixe.'\''; ?>)"><?= $data->type; ?></button><?php */ ?>
										<button class="mp_<?php echo $data->id_mp; ?> btn btn-lg btn-default btn-block modePaiement <?php echo $selectedModePaiement ?>" onclick="Afficher_RR(this)" data-rr="<?php echo $data->RR ?>" data-prefixe="<?php echo $data->prefixe ?>" data-id_mp="<?php echo $data->id_mp ?>"><?= $data->type; ?></button>
									</div>	
								<?php
									}
								?>
								</div>
							</div>
						</div>	
            		</div>
					
					<div style="height: 175px" id="TypeMP">
						<input type="hidden" id="modePaiement" value="1">

						<div class="col-lg-6" id="Content_RenduMP">
							<div class="form-group">
								<label for="RenduMP">RECU</label>
								<div class="input-group">
									<input class="form-control" id="RecuMP" type="text" disabled="true">
									<span class="input-group-addon"><i class="fa fa-check"></i></span>
								</div>
							</div>
	            			
	            			<div class="form-group">
								<label for="exampleInputEmail1">RENDU</label>
								<div class="input-group">
									<input class="form-control" disabled="true" id="RenduMP" type="text">
									<span class="input-group-addon"><i class="fa fa-times"></i></span>
								</div>
							</div>	            			
	            		</div>
						
						<div class="col-lg-6 hide" id="Content_ReferenceMP">
							<div class="form-group">
								<label for="RenduMP">REFERENCE</label>
								<div class="input-group">
									<input class="form-control" id="ReferenceMP" type="text">
									<span class="input-group-addon"><i class="fa fa-check"></i></span>
								</div>
							</div>
	            		</div>
					</div>      		

            		<div class="col-lg-6">
            			<div class="row">
            				<div class="col-sm-4"><button class="btn btn-info btn-lg btn-block B btn_55" value="7">7</button></div>
            				<div class="col-sm-4"><button class="btn btn-info btn-lg btn-block B btn_56" value="8">8</button></div>
            				<div class="col-sm-4"><button class="btn btn-info btn-lg btn-block B btn_57" value="9">9</button></div>
            				<div class="col-sm-4"><button class="btn btn-info btn-lg btn-block B btn_52" value="4">4</button></div>
            				<div class="col-sm-4"><button class="btn btn-info btn-lg btn-block B btn_53" value="5">5</button></div>
            				<div class="col-sm-4"><button class="btn btn-info btn-lg btn-block B btn_54" value="6">6</button></div>
            				<div class="col-sm-4"><button class="btn btn-info btn-lg btn-block B btn_49" value="1">1</button></div>
            				<div class="col-sm-4"><button class="btn btn-info btn-lg btn-block B btn_50" value="2">2</button></div>
            				<div class="col-sm-4"><button class="btn btn-info btn-lg btn-block B btn_51" value="3">3</button></div>
            				<div class="col-sm-4"><button class="btn btn-info btn-lg btn-block B btn_48" value="0">0</button></div>
							<div class="col-sm-4"><button class="btn btn-info btn-lg btn-block B btn_8" onclick="retour_MP()"><i class="fa fa-arrow-left"></i></button></div>
							<div class="col-sm-4"><button class="btn btn-info btn-lg btn-block B btn_114" onclick="reload_MP()">CE</button></div>
            			</div>
            		</div>
            	</div>
            </div>
            <div class="modal-footer">
                <span class="btn btn-danger btn-sm" data-dismiss="modal" aria-hidden="true">Annuler</span>
                <span class="btn btn-success btn-sm btn_13" aria-hidden="true" onclick="MP_OK()">OK</span>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>