<?php include './base/header.php' ?>

<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="#"><i class="fa fa-home"></i> Home</a>
                    <span>Contact</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Map Begin -->
<div class="map">
    <div class="container">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2942.5524090066037!2d-71.10245469994108!3d42.47980730490846!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e3748250c43a43%3A0xe1b9879a5e9b6657!2sWinter%20Street%20Public%20Parking%20Lot!5e0!3m2!1sen!2sbd!4v1577299251173!5m2!1sen!2sbd"
            height="585" style="border:0;" allowfullscreen=""></iframe>
    </div>
</div>
<!-- Map End -->

<!-- Contact Section Begin -->
<section class="contact py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="contact__address">
                    <div class="section-title">
                        <h2>Contact info</h2>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore.</p>
                    <ul>
                        <li>
                            <i class="fa fa-map-marker"></i>
                            <h5>Address</h5>
                            <p>Los Angeles Gournadi, 1230 Bariasl</p>
                        </li>
                        <li>
                            <i class="fa fa-phone"></i>
                            <h5>Hotline</h5>
                            <span>1-677-124-44227</span>
                            <span>1-688-356-66889</span>
                        </li>
                        <li>
                            <i class="fa fa-envelope"></i>
                            <h5>Email</h5>
                            <p>Support@gamail.com</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="contact__form">
                    <div class="section-title">
                        <h2>Get in touch</h2>
                    </div>
                    <p>Eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices
                        gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                    <form id="contactForm" action="#">
                        <div class="input__list">
                            <input type="text" id="name" placeholder="Name" required>
                            <input type="text" id="email" placeholder="Email" required>
                            <input type="text" id="website" placeholder="Website">
                        </div>
                        <textarea id="comment" placeholder="Comment" required></textarea>
                        <button type="submit" class="site-btn">SEND MESSAGE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('contactForm').addEventListener('submit', function (e) {
        e.preventDefault(); // prevent form submission

        // Get form values
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const website = document.getElementById('website').value.trim();
        const comment = document.getElementById('comment').value.trim();

        // Regex patterns
        const nameRegex = /^[A-Za-z\s]+$/; // only letters and spaces
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // basic email
        const urlRegex = /^(https?:\/\/)?([\w-]+\.)+[\w-]+(\/[\w- ./?%&=]*)?$/; // simple URL

        // Validation
        if (!nameRegex.test(name)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Name must contain only letters and spaces.'
            });
            return;
        }

        if (!emailRegex.test(email)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter a valid email address.'
            });
            return;
        }

        if (website && !urlRegex.test(website)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter a valid website URL.'
            });
            return;
        }

        if (comment === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Comment cannot be empty.'
            });
            return;
        }

        // Success
        Swal.fire({
            icon: 'success',
            title: 'Message Sent!',
            text: 'Your message has been submitted successfully.',
            confirmButtonText: 'OK'
        }).then(() => {
            // Optionally reset the form after success
            document.getElementById('contactForm').reset();
        });
    });
</script>


<!-- Contact Section End -->
<?php include './base/footer.php' ?>