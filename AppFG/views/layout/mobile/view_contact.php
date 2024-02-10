



    <!-- Page Content -->

    <div class="page-content m-t70 m-b70">

        <div class="account-box">

            <div class="container">

                <div class="account-area">

                    <h3 class="title p-b50">Kontakt Seite</h3>

                    <p><?php echo $page_contact['contact_email']; ?></p>

                    <p><?php echo $page_contact['contact_phone']; ?></p>

                    <p>Hauptsitz: <br><?php echo $page_contact['contact_address']; ?></p>

					<?php echo form_open(base_url('mobile/contact/send_email'), array('class' => 'contact-form input-style3', 'name' =>'form_contact')); ?>

						<div class="input-group input-mini mb-3">

							<span class="input-group-text"><i class="fa fa-user"></i></span>

                            <input type="text" class="form-control" placeholder="Name" name="name" autocomplete="off" required>

						</div>

						<div class="input-group input-mini mb-3">

							<span class="input-group-text"><i class="fa fa-envelope"></i></span>

							<input type="email" class="form-control" placeholder="Email" name="email" autocomplete="off" required>

						</div>

						<div class="input-group input-mini mb-3">

							<span class="input-group-text"><i class="fa fa-phone"></i></span>

							<input type="text" class="form-control" placeholder="Phone" name="phone" autocomplete="off" required>

						</div>

						<div class="input-group input-mini mb-3">

							<span class="input-group-text"><i class="fa fa-pencil"></i></span>

							<input type="text" class="form-control" placeholder="Subject" name="subject" autocomplete="off" required>

						</div>

						<div class="input-group input-mini mb-3">

							<span class="input-group-text"><i class="fa fa-message"></i></span>

							<textarea class="form-control" placeholder="Message" name="message" autocomplete="off" required></textarea>

						</div>

						<div class="input-group">

							<a href="#" class="btn mt-2 btn-primary w-100 btn-rounded contact_btn">ABSENDEN</a>

						</div>

                    <?php echo form_close(); ?>

                    <div class="text-center mb-auto p-tb20">

                        -

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Page Content End -->





	<!-- Success Bar -->

	<div class="modal fade" tabindex="-1" id="exampleModal4"  aria-labelledby="exampleModal4" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-body text-center small p-4">

					<i class="fa fa-4x fa-check-circle text-success m-b15"></i>

					<h5>Successfully</h5>

                    <p class="m-b0">Ihre Nachricht wurde erfolgreich versendet!</p>

                </div>

            </div>

        </div>

    </div>