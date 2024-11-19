<?php include 'templates/header.php'; ?>

<div id="contact-page" class="container">
    	<div class="bg">
	    	<div class="row">    		
	    		<div class="col-sm-12">    			   			
					<h2 class="title text-center">Liên hệ <strong>với chúng tôi</strong></h2>    			    				    				
					<div id="gmap" class="contact-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.0146951116626!2d105.77135407477037!3d21.072075286290374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3134552defbed8e9%3A0x1584f79c805eb017!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBN4buPIC0gxJDhu4thIGNo4bqldA!5e0!3m2!1svi!2s!4v1732003624194!5m2!1svi!2s"
						 width="1200" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
					</div>
				</div>			 		
			</div>    	
    		<div class="row">  	
	    		<div class="col-sm-8">
	    			<div class="contact-form" >
	    				<h2 class="title text-center">Gửi thông tin tới chúng tôi để được hỗ trợ!</h2>
	    				<div class="status alert alert-success" style="display: none"></div>
				    	<?= view('contact/mail'); ?>
	    			</div>
	    		</div>
	    		<div class="col-sm-4">
	    			<div class="contact-info">
	    				<h2 class="title text-center">Thông tin liên hệ</h2>
	    				<address>
	    					<p>The Computer Shop</p>
							<p>Bắc Từ Liêm, Hà Nội</p>
							<p>Số liên hệ: 08124533636</p>
							<p>Email: testwithdraw001@gmail.com</p>
	    				</address>
	    				<div class="social-networks">
	    					<h2 class="title text-center">Mạng xã hội</h2>
							<ul>
								<li>
									<a href="https://www.facebook.com/profile.php?id=100016067703834"><i class="fa fa-facebook"></i></a>
								</li>
								<li>
									<a href="https://twitter.com/"><i class="fa fa-twitter"></i></a>
								</li>
							</ul>
	    				</div>
	    			</div>
    			</div>    			
	    	</div>  
    	</div>	
    </div><!--/#contact-page-->

<?php include 'templates/footer.php'; ?>