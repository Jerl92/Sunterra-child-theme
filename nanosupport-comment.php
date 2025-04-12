<?php
//highlight the latest response on successful submission of new response
                                        $fresh_response = (isset($_GET['ns_success']) || isset($_GET['ns_cm_success']) ) && $found_count == $counter ? 'new-response' : '';
                                       // echo print_r( $response );
                                        ?>

                                            <div class="ticket-response-cards ns-cards <?php echo esc_attr($fresh_response); ?>">
                                                <div class="ns-row">
                                                    <div class="ns-col-sm-6">
                                                        <div class="response-head">
                                                            <h3 class="ticket-head" id="response-<?php echo esc_attr($counter); ?>">
                                                                <?php echo $response->comment_author; ?>
                                                            </h3>
                                                        </div> <!-- /.response-head -->
                                                    </div>
                                                    <div class="ns-col-sm-6 response-dates">
                                                        <a href="#response-<?php echo esc_attr($counter); ?>" class="response-bookmark ns-small"><strong class="ns-hash">#</strong> <?php echo date( 'd M Y h:iA', strtotime( $response->comment_date ) ); ?></a>
                                                    </div>
                                                </div> <!-- /.ns-row -->
                                                <div class="ticket-response">
                                                    <?php echo wpautop( $response->comment_content ); ?>
                                                </div>
                                                
                                            </div> <!-- /.ticket-response-cards -->

                                            <?php
                                        $counter++;
                                    ?>
