        <?php

            if(isset($_POST['up'])){
                foreach ($_POST as $k => $v) {
                    if($k != 'up' && $k!='next'){

                        $vals = explode("_", $k);

                        if($vals[0] == "format"){
                            $pouls=$em->getRepository('Poule')->findBy(array(
                              'id' => $vals[1]
                            ));
                            $pouls[0]->setFormat($v);
                            $em->persist($pouls[0]);
                        }elseif($vals[0] == "score"){
                            $match=$em->getRepository('MatchPoule')->findBy(array(
                              'equipe1' => $vals[1],
                              'equipe2' => $vals[2],
                              'poule' => $vals[3]
                            ));

                            $match[0]->setScore($v);
                            $em->persist($match[0]);
                        }else{
                            $match=$em->getRepository('MatchPoule')->findBy(array(
                              'equipe1' => $vals[1],
                              'equipe2' => $vals[2],
                              'poule' => $vals[3]
                            ));

                            $match[0]->setTerrain($v);
                            $em->persist($match[0]);
                        }
                    }
                }
                $em->flush();
            }

            $poules=$em->getRepository('Poule')->findBy(array(
                    'tournoi' => $_GET['id'],
                    'tour' => $tournoi->getTour()
                ));
        ?>
            <form method="post" action="gestion.php?id=<?php echo $tournoi->getId();?>"><button id="nextTour" name='next' value="1">Tour suivant</button></form>
            <form method="post" action="gestion.php?id=<?php echo $tournoi->getId();?>"><button id="fin" name='fin' value="1">Terminer le tournoi</button></form>


        <h2>Scores</h2> 
        <div class="content">
            <nav class="gauche">
                
                <?php

                    $poules=$em->getRepository('Poule')->findBy(array(
                      'tournoi' => $tournoi->getId()
                    ));

                    foreach ($poules as $p) {
                        echo sprintf("<a href='#%d'>%s</a>",$p->getId(),$p->getNom());
                    }

                ?>

            </nav>
            <section class="droite">
                <form action="gestion.php?id=<?php echo $_GET['id']; ?>" method="post">

                    <?php

                        foreach ($poules as $p) {
                            echo sprintf("<article id='%d'> 
                                            <h3>%s <input type='text' placeholder='Format des matchs' name='format_%d' value='%s'></h3>
                                            <br />
                                            <table>
                                                <tr>
                                                    <th>Match</th>
                                                    <th>Terrain</th>
                                                    <th>Score</th>
                                                </tr>",$p->getId(),$p->getNom(), $p->getId(),$p->getFormat());

                            $matchs=$em->getRepository('MatchPoule')->findBy(array(
                              'poule' => $p->getId()
                            ));
                            foreach ($matchs as $m) {
                                echo sprintf("<tr>
                                                <td>%s VS %s</td>
                                                <td><input type='text' class='terrain' name='terrain_%s_%s_%d' value='%s'</td>
                                                <td><input type='text' class='score' name='score_%s_%s_%d' value='%s'></td>
                                              </tr>", 
                                            $m->getEquipe1()->getNom(), $m->getEquipe2()->getNom(),$m->getEquipe1()->getNom(), $m->getEquipe2()->getNom(),$m->getPoule()->getId(), $m->getTerrain(),$m->getEquipe1()->getNom(), $m->getEquipe2()->getNom(),$m->getPoule()->getId(),$m->getScore()); 
                              
                            }
                            echo "</table></article>";
                        }

                    ?>
                    <input type="submit" name="up" id="maj" value="Mettre à jour" />
                </form>

            </section>
        </div>