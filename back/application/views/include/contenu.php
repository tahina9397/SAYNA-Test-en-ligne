<div class="content">
            <div class="container-fluid">
                <div class="row">
                        <!--<p>Tout le contenu ici</p>-->
                        <div class="col-md-4">    
                        </div>
                        <div class="col-md-4">
                            <div class="w3-content w3-section" style="max-width:500px">
                              <!--<img class="mySlides w3-animate-fading" src="<?php echo img_url('1.png'); ?>" style="width:100%">
                              <img class="mySlides w3-animate-fading" src="<?php echo img_url('logo.png'); ?>" style="width:100%">-->
                            </div>
                            <script>
                            var myIndex = 0;
                            carousel();

                            function carousel() {
                                var i;
                                var x = document.getElementsByClassName("mySlides");
                                for (i = 0; i < x.length; i++) {
                                   x[i].style.display = "none";  
                                }
                                myIndex++;
                                if (myIndex > x.length) {myIndex = 1}    
                                x[myIndex-1].style.display = "block";  
                                setTimeout(carousel, 9000);    
                            }
                            </script> 
                            <script language="JavaScript">
                                <!-- begin script
                                var pos1=0, pos2=0, Fin2;
                                MsgN="Bienvenue sur notre site. Consulter, exporter vos statistiques. Ecouter et télécharger vos enregistrements"; 
                                delai = 100;
                                function TexteMultiligne() {
                                   if (pos1 > MsgN.length) {
                                      document.formnouv.multi1.value = '';
                                      pos1 = 0;
                                      pos2 = 0;
                                   }
                                   else if (MsgN.substring(pos1-2,pos1-1) == '.') {
                                     document.formnouv.multi1.value = '';
                                     pos2 = pos1-1;
                                     pos1++;
                                   }
                                   else {
                                     document.formnouv.multi1.value = MsgN.substring(pos1,pos2);  
                                     pos1++;
                                   }
                                   Fin2 = setTimeout("TexteMultiligne() ", delai);
                                }
                                // end script
                                </script>
                                <form name="formnouv">
                                <textarea name="multi1" COLS="40" ROWS="1"></textarea>
                                </form>   
                        </div>
                        <div class="col-md-4">    
                        </div>                                       
                </div>
            </div>
        </div>