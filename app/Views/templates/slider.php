<section id="slider"><!--slider-->
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div id="slider-carousel" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
						<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
						<li data-target="#slider-carousel" data-slide-to="1"></li>
						<li data-target="#slider-carousel" data-slide-to="2"></li>
					</ol>

					<style>
                        .carousel-inner .item img {
                            margin-left:-40px;
                            height: 400px;
                            width: 100%;
                        }
                    
					</style>

					<div class="carousel-inner">
						<div class="item active">

							<div class="col-sm-12">
								<img src="<?= base_url('assets/images/banner1.jpg') ?>" class="girl img-responsive" alt="" width="1797" height="744"/>
								
							</div>
						</div>
						<div class="item">

							<div class="col-sm-12">
								<img src="<?= base_url('assets/images/banner2.png') ?>" class="girl img-responsive" alt="" width="1797" height="744"/>
								
							</div>
						</div>

						<div class="item">

							<div class="col-sm-12">
								<img src="<?= base_url('assets/images/banner3.jpg') ?>" class="girl img-responsive" alt="" width="1797" height="744"/>
								
							</div>
						</div>

					</div>

					<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
						<i class="fa fa-angle-left"></i>
					</a>
					<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
						<i class="fa fa-angle-right"></i>
					</a>
				</div>

			</div>
		</div>
	</div>
</section><!--/slider-->





