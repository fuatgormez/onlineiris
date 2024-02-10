    <!-- Page Content -->

    <div class="page-content m-t100">

        <div class="container fb">

            <!-- row -->

            <div class="row">

                <!-- Column starts -->

				<div class="col-12">

                    <div class="card">

                        <div class="card-header d-block">

                            <h5 class="title">FAQ</h5>

                        </div>

                        <div class="card-body">

                            <div class="accordion style-2" id="accordionFaq">

                                <?php foreach($faq as $key => $row):?>

								<div class="accordion-item">

									<h2 class="accordion-header" id="headingOne">

										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $key;?>" aria-expanded="true" aria-controls="collapse<?php echo $key;?>">

											<i class="fa-solid fa-wallet me-2"></i>

											<?php echo $row['faq_title'];?>

										</button>

									</h2>

									<div id="collapse<?php echo $key;?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionFaq">

										<div class="accordion-body">

											<?php echo $row['faq_content'];?>

										</div>

									</div>

								</div>

                                <?php endforeach;?>

							</div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Page Content End -->