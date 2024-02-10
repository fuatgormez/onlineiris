<!DOCTYPE html>
<html lang="en">
<head>
    
    <!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1,user-scalable=0, minimal-ui, viewport-fit=cover">
	<meta name="theme-color" content="#2196f3">
	<meta name="author" content="" /> 
    <meta name="keywords" content="" /> 
    <meta name="robots" content="" /> 
	<meta name="description" content=""/>
	<meta property="og:title" content="" />
	<meta property="og:description" content="" />
	<meta property="og:image" content="https://makaanlelo.com/tf_products_007/foodia/xhtml/social-image.png"/>
	<meta name="format-detection" content="telephone=no">
    
	<!-- Title -->
	<title><?php echo $setting['sitename'];?></title>

    <!-- Favicons Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('public/uploads/'.$setting['favicon']);?>" />

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo base_url();?>public/layout/mobile/assets/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/layout/mobile/assets/css/style.css?v=<?php echo time();?>">
    
	<?php if(in_array($this->router->fetch_class(), ['gallery'])):?>
	<link href="<?php echo base_url();?>public/layout/mobile/assets/vendor/lightgallery/dist/css/lightgallery.css" rel="stylesheet">
	<link href="<?php echo base_url();?>public/layout/mobile/assets/vendor/lightgallery/dist/css/lg-thumbnail.css" rel="stylesheet">
	<link href="<?php echo base_url();?>public/layout/mobile/assets/vendor/lightgallery/dist/css/lg-zoom.css" rel="stylesheet">
	<?php endif;?>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&family=Roboto+Slab:wght@100;300;500;600;800&display=swap" rel="stylesheet">
	
	<?php if(!in_array($this->router->fetch_class(), ['checkout', 'contact', 'upload'])):?>
	<!-- Pull to Refresh -->
    <link rel="stylesheet" type="text/css" href="https://www.boxfactura.com/pulltorefresh.js/demos/style.css">
	<style id="pull-to-refresh-js-style"> .ptr--ptr { box-shadow: inset 0 -3px 5px rgba(0, 0, 0, 0.12); pointer-events: none; font-size: 0.85em; font-weight: bold; top: 0; height: 0; transition: height 0.3s, min-height 0.3s; text-align: center; width: 100%; overflow: hidden; display: flex; align-items: flex-end; align-content: stretch; } .ptr--box { padding: 10px; flex-basis: 100%; } .ptr--pull { transition: none; } .ptr--text { margin-top: .33em; color: rgba(0, 0, 0, 0.3); } .ptr--icon { color: rgba(0, 0, 0, 0.3); transition: transform .3s; } /* When at the top of the page, disable vertical overscroll so passive touch listeners can take over. */ .ptr--top { touch-action: pan-x pan-down pinch-zoom; } .ptr--release .ptr--icon { transform: rotate(180deg); } </style>
	<!-- / Pull to Refresh -->
	<?php endif;?>

	<?php if(base_url() === 'https://www.irisandpet.de/'):?>
	<!-- Meta Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window, document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '1004779750102371');
	fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
	src="https://www.facebook.com/tr?id=1004779750102371&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Meta Pixel Code -->
	<!-- Zoho -->
	<script type="text/javascript" id="zsiqchat">var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || {widgetcode: "siqbcd38c8068556989de5eeaa7c93d4a2e735d7583de925fe797574bc51e51ca55", values:{},ready:function(){}};var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;s.src="https://salesiq.zoho.eu/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);</script>
	<!-- End Zoho -->
	<?php endif;?>
</head>
<body class="bg-white" id="main">
<div class="page-wraper">
	<!-- Preloader -->
	<div id="preloader">
		<div class="spinner"></div>
	</div>
    <!-- Preloader end-->
	<!-- Loading -->
	<div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasLoading" aria-labelledby="offcanvasLoadingLabel" aria-modal="true" role="dialog" style="visibility: visible; display: show;">
		<div class="offcanvas-header">
			<div>
				<h5 class="offcanvas-title" id="offcanvasLoadingLabel">Loading...</h5>
			</div>
			<button class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
		</div>
	</div>
	<!-- Loading End -->
    <!-- Header -->
	<header class="header transparent">
		<div class="main-bar">
			<div class="container">
				<div class="header-content">
					<div class="left-content">
						<a href="javascript:void(0);" class="menu-toggler">
							<svg fill="#000000" height="30" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M4 6H20M4 12H20M4 18H20" stroke="#4A5568" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
						</a>
					</div>
					<div class="mid-content px-2 mt-2 ">
                        <a href="<?php echo base_url('mobile');?>">
							<img src="<?php echo base_url('public/uploads/'.$setting['logo']);?>" width="200">
						</a>
					</div>
					<div class="right-content d-none">
					<?php if(in_array($this->router->fetch_class(),['shop'])):?>
                        <a href="javascript:void(0);" class="position-relative me-2 notify-cart" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom2" aria-controls="offcanvasBottom">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.1776 17.8443C16.6362 17.8428 15.3854 19.0912 15.3839 20.6326C15.3824 22.1739 16.6308 23.4247 18.1722 23.4262C19.7136 23.4277 20.9643 22.1794 20.9658 20.638C20.9658 20.6371 20.9658 20.6362 20.9658 20.6353C20.9644 19.0955 19.7173 17.8473 18.1776 17.8443Z" fill="#2C406E"/>
                                <path d="M23.1278 4.47973C23.061 4.4668 22.9932 4.46023 22.9251 4.46012H5.93181L5.66267 2.65958C5.49499 1.46381 4.47216 0.574129 3.26466 0.573761H1.07655C0.481978 0.573761 0 1.05574 0 1.65031C0 2.24489 0.481978 2.72686 1.07655 2.72686H3.26734C3.40423 2.72586 3.52008 2.82779 3.53648 2.96373L5.19436 14.3267C5.42166 15.7706 6.66363 16.8358 8.12528 16.8405H19.3241C20.7313 16.8423 21.9454 15.8533 22.2281 14.4747L23.9802 5.74121C24.0931 5.15746 23.7115 4.59269 23.1278 4.47973Z" fill="#2C406E"/>
                                <path d="M11.3404 20.5158C11.2749 19.0196 10.0401 17.8418 8.54244 17.847C7.0023 17.9092 5.80422 19.2082 5.86645 20.7484C5.92617 22.2262 7.1283 23.4008 8.60704 23.4262H8.67432C10.2142 23.3587 11.4079 22.0557 11.3404 20.5158Z" fill="#2C406E"/>
                            </svg>
                            <span class="badge badge-danger counter total_items"><?php echo $this->cart->total_items() ?? 0;?></span>
                        </a>
					<?php endif;?>
					</div>
				</div>
			</div>
		</div>
	</header>
    <!-- Header End -->
	<!-- Sidebar -->
    <div class="sidebar">
		<div class="author-box">
			<div class="dz-info">
				<h5 class="name"><?php echo $setting['sitename'];?></h5>
			</div>
		</div>
		<ul class="nav navbar-nav">
			<li class="nav-label">Main Menu</li>
			<li><a class="nav-link" href="<?php echo base_url('mobile');?>">
				<span class="dz-icon">
				<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 113.97"><defs><style>.cls-1{fill-rule:evenodd;}</style></defs><title>homepage</title><path class="cls-1" d="M18.69,73.37,59.18,32.86c2.14-2.14,2.41-2.23,4.63,0l40.38,40.51V114h-30V86.55a3.38,3.38,0,0,0-3.37-3.37H52.08a3.38,3.38,0,0,0-3.37,3.37V114h-30V73.37ZM60.17.88,0,57.38l14.84,7.79,42.5-42.86c3.64-3.66,3.68-3.74,7.29-.16l43.41,43,14.84-7.79L62.62.79c-1.08-1-1.24-1.13-2.45.09Z"/></svg>
				</span>
				<span>Home</span>
			</a></li>
			<li><a class="nav-link" href="<?php echo base_url('mobile/shop');?>">
				<span class="dz-icon">
				<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 116.31" style="enable-background:new 0 0 122.88 116.31" xml:space="preserve"><g><path d="M4.06,12.67C1.87,12.67,0,10.8,0,8.51c0-2.19,1.87-4.06,4.06-4.06h5.62c0.1,0,0.31,0,0.42,0c3.75,0.1,7.08,0.83,9.88,2.6 c3.12,1.98,5.41,4.99,6.66,9.47c0,0.1,0,0.21,0.1,0.31L27.78,21h2.34V4.12c0-2.27,1.85-4.12,4.12-4.12h21.67 c2.27,0,4.12,1.85,4.12,4.12v10.02c3.42-3.41,8.06-5.5,13.18-5.5c2.22,0,4.36,0.4,6.34,1.12c4.08-4.33,9.87-7.04,16.29-7.04 c10.96,0,20.07,7.88,21.99,18.28h0.99c2.29,0,4.06,1.87,4.06,4.06c0,0.42-0.11,0.83-0.21,1.25l-10.61,42.76 c-0.42,1.87-2.08,3.12-3.95,3.12l0,0H41.51c1.46,5.41,2.91,8.32,4.89,9.68c2.39,1.56,6.56,1.66,13.53,1.56h0.1l0,0h47.03 c2.29,0,4.06,1.87,4.06,4.06c0,2.29-1.87,4.06-4.06,4.06H60.04l0,0c-8.64,0.1-13.94-0.1-18.21-2.91 c-4.37-2.91-6.66-7.91-8.95-16.96l0,0L18.94,18.92c0-0.1,0-0.1-0.1-0.21c-0.62-2.29-1.66-3.85-3.12-4.68 c-1.46-0.94-3.43-1.35-5.72-1.35c-0.1,0-0.21,0-0.31,0H4.06L4.06,12.67L4.06,12.67z M84.38,37.69c0-1.28,1.27-2.32,2.83-2.32 c1.56,0,2.83,1.04,2.83,2.32v15.69c0,1.28-1.27,2.32-2.83,2.32c-1.56,0-2.83-1.04-2.83-2.32V37.69L84.38,37.69z M67.43,37.69 c0-1.28,1.27-2.32,2.83-2.32c1.56,0,2.83,1.04,2.83,2.32v15.69c0,1.28-1.27,2.32-2.83,2.32c-1.56,0-2.83-1.04-2.83-2.32V37.69 L67.43,37.69z M50.49,37.69c0-1.28,1.27-2.32,2.83-2.32c1.56,0,2.83,1.04,2.83,2.32v15.69c0,1.28-1.27,2.32-2.83,2.32 c-1.56,0-2.83-1.04-2.83-2.32V37.69L50.49,37.69z M85.57,13.37c2.31,2.05,4.14,4.66,5.29,7.63h19.85 c-1.68-6.65-7.7-11.58-14.87-11.58C91.89,9.42,88.29,10.91,85.57,13.37L85.57,13.37z M92.21,29.11L92.21,29.11l-38.01,0l0,0H30.07 l0,0l9.26,34.86h65.65l8.63-34.86H92.21L92.21,29.11z M55.31,21c0.11-0.29,0.23-0.57,0.35-0.85V7.2c0-1.64-1.35-2.99-2.99-2.99 H37.71c-1.64,0-2.99,1.34-2.99,2.99V21H55.31L55.31,21z M94.89,96.33c5.52,0,9.99,4.47,9.99,9.99s-4.47,9.99-9.99,9.99 c-5.51,0-9.99-4.47-9.99-9.99S89.38,96.33,94.89,96.33L94.89,96.33L94.89,96.33z M51.09,96.33c5.51,0,9.99,4.47,9.99,9.99 s-4.47,9.99-9.99,9.99s-9.99-4.47-9.99-9.99S45.57,96.33,51.09,96.33L51.09,96.33L51.09,96.33z"/></g></svg>
				</span>
				<span>Shop</span>
			</a></li>
			<li><a class="nav-link" href="<?php echo base_url('mobile/gallery');?>">
				<span class="dz-icon">
				<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="122.879px" height="96.568px" viewBox="0 0 122.879 96.568" enable-background="new 0 0 122.879 96.568" xml:space="preserve"><g><path d="M5.535,15.447h98.221c1.527,0,2.891,0.62,3.883,1.611c0.99,0.991,1.611,2.396,1.611,3.882v70.134 c0,1.528-0.621,2.891-1.611,3.883c-0.082,0.082-0.166,0.165-0.289,0.247c-0.951,0.868-2.23,1.363-3.635,1.363H5.494 c-1.528,0-2.892-0.619-3.883-1.61S0,92.562,0,91.075V20.941c0-1.528,0.62-2.891,1.611-3.882s2.396-1.611,3.883-1.611H5.535 L5.535,15.447z M28.218,34.489c4.354,0,7.882,3.528,7.882,7.882s-3.528,7.883-7.882,7.883c-4.354,0-7.882-3.529-7.882-7.883 C20.335,38.018,23.864,34.489,28.218,34.489L28.218,34.489z M61.389,68.316l15.766-27.258l16.748,42.363l-78.165-0.001v-5.254 l6.57-0.327l6.567-16.093l3.282,11.496h9.855l8.537-22.004L61.389,68.316L61.389,68.316z M21.891,6.525 c-1.817,0-3.263-1.486-3.263-3.263C18.628,1.445,20.115,0,21.891,0h97.726c1.816,0,3.262,1.487,3.262,3.263v68.895 c0,1.818-1.486,3.264-3.262,3.264c-1.818,0-3.264-1.487-3.264-3.264V6.567H21.891V6.525L21.891,6.525z M102.723,21.974H6.567 v68.027h96.155V21.974L102.723,21.974z"/></g></svg>
				</span>
				<span>Gallery</span>
			</a></li>
			<li><a class="nav-link" href="<?php echo base_url('mobile/faq');?>">
				<span class="dz-icon">
				<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 116.6"><title>faqs</title><path d="M17.72,45.43V21.12h16.8v5.32H24.21v4.18h9.28v5.31H24.21v9.5ZM16.67,0h66.5A16.7,16.7,0,0,1,99.84,16.67V51.36A16.7,16.7,0,0,1,83.17,68H45.46L20.16,89.78a2.81,2.81,0,0,1-4.62-2.31L16.89,68h-.22A16.7,16.7,0,0,1,0,51.36V16.67A16.7,16.7,0,0,1,16.67,0Zm93,24.65a16.42,16.42,0,0,1,13.26,16V77.85a16.37,16.37,0,0,1-16.33,16.32H106L107.34,114h0a2.46,2.46,0,0,1-4,2L77.89,93.53H38.26L54.74,76.77H95.82a13.9,13.9,0,0,0,13.85-13.86V25.75c0-.37,0-.74,0-1.1Zm-26.46-19H16.67a11.1,11.1,0,0,0-11,11.05V51.36a11.1,11.1,0,0,0,11.05,11h3.42a2.8,2.8,0,0,1,2.6,3L21.6,81.17l20.87-18a2.79,2.79,0,0,1,2-.81H83.16a11.1,11.1,0,0,0,11-11V16.67a11.1,11.1,0,0,0-11-11Zm-43,39.81h-7L41,21.12h8.87l7.88,24.31h-7L45.53,27.82h-.19L40.12,45.43Zm-1.31-9.59H52v4.94H38.81V35.84Zm29.35.57h5L75,38.74l3.08,3.55,4,5H76.37l-2.84-3.37-1.92-2.81-3.45-4.65Zm13.91-3.13a13.84,13.84,0,0,1-1.56,6.84,10.36,10.36,0,0,1-4.19,4.21,12.78,12.78,0,0,1-11.77,0,10.45,10.45,0,0,1-4.18-4.23,13.83,13.83,0,0,1-1.54-6.81,13.89,13.89,0,0,1,1.54-6.84,10.42,10.42,0,0,1,4.18-4.22,12.82,12.82,0,0,1,11.77,0,10.45,10.45,0,0,1,4.19,4.22,13.78,13.78,0,0,1,1.56,6.84Zm-6.68,0a10.35,10.35,0,0,0-.57-3.68,4.75,4.75,0,0,0-1.66-2.29,5.17,5.17,0,0,0-5.43,0,4.83,4.83,0,0,0-1.67,2.29,10.59,10.59,0,0,0-.56,3.68A10.63,10.63,0,0,0,66.06,37a4.8,4.8,0,0,0,1.67,2.28,5.12,5.12,0,0,0,5.43,0A4.72,4.72,0,0,0,74.82,37a10.38,10.38,0,0,0,.57-3.68Z"/></svg>
				</span>
				<span>FAQ</span>
			</a></li>
			<li><a class="nav-link" href="<?php echo base_url('mobile/contact');?>">
				<span class="dz-icon">
				<svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 115.65 122.88" style="enable-background:new 0 0 115.65 122.88" xml:space="preserve"><style type="text/css"><![CDATA[.st0{fill-rule:evenodd;clip-rule:evenodd;}]]></style><g><path class="st0" d="M29.73,56.99l5.52-0.14l2.61-0.07l3.97,4.61c0.93,1.08,1.88,2.17,2.92,3.22c-0.74,1.1-4.04,3.91-6.98,6.39 c-1.3,1.1-2.53,2.15-3.48,3c-7.45,2.89-14.73,5.86-20.37,9.41C6.05,88.36,2.06,96.6,0.18,105.5c-0.58,7.83-0.01,7.44,5.5,7.35 c21.68-0.21,43.41,0.11,65.11,0.2c-4.32-9.74-2.49-21.55,5.5-29.54c3.35-3.35,7.37-5.61,11.62-6.8c-2.31-0.96-4.68-1.89-7.08-2.81 c-0.68-0.61-1.44-1.27-2.22-1.95c-2.47-2.16-5.25-4.6-6.38-6c1.77-1.55,3.26-3.33,4.73-5.1l2.49-3c0.04-0.05,0.23-0.27,0.51-0.59 c0.14-0.17,0.29-0.33,0.45-0.53h5.45c8.04-17.2,2.93-42.72-13.48-53.54C67.33-0.13,63.71,0,57.8,0c-6.77,0-10.22,0.22-16.02,4.05 C33.22,9.7,27.97,19.49,25.76,33.07C25.3,39.84,25,51.54,29.73,56.99L29.73,56.99L29.73,56.99L29.73,56.99z M109.61,87.72 c8.04,8.04,8.04,21.08,0,29.13c-8.04,8.04-21.08,8.04-29.13,0s-8.04-21.08,0-29.13C88.53,79.68,101.57,79.68,109.61,87.72 L109.61,87.72L109.61,87.72z M92.88,90.51h4.34c0.59,0,1.08,0.49,1.08,1.08v7.44h7.45c0.59,0,1.08,0.49,1.08,1.08v4.34 c0,0.59-0.49,1.08-1.08,1.08H98.3v7.44c0,0.59-0.49,1.08-1.08,1.08h-4.34c-0.59,0-1.08-0.49-1.08-1.08v-7.44h-7.44 c-0.59,0-1.08-0.49-1.08-1.08v-4.34c0-0.59,0.49-1.08,1.08-1.08h7.44v-7.44C91.8,91,92.29,90.51,92.88,90.51L92.88,90.51z M39.16,54.53c-4.49-15.6-2.31-29.95,9.99-42.23c2.18,7.06,7.07,12.88,15.41,17.18C68.54,32.43,72.4,36,76.12,40.1 c0.66-2.72-1.87-6.03-4.92-9.43c2.84,1.4,5.43,3.35,7.27,7.11c2.14,4.37,2.11,8.05,1.4,12.79c-0.21,1.37-0.49,2.68-0.85,3.93 c-0.25,0.1-0.46,0.24-0.61,0.42c-0.33,0.41-0.68,0.81-0.99,1.18c-0.1,0.12-0.18,0.21-0.52,0.62l-2.49,3 c-1.9,2.29-3.83,4.57-6.26,6.24c-2.33,1.59-5.18,2.64-9.1,2.63c-3.6-0.01-6.34-1.02-8.59-2.53c-2.36-1.57-4.26-3.73-6.08-5.83 l-4.55-5.29C39.66,54.75,39.43,54.62,39.16,54.53L39.16,54.53L39.16,54.53L39.16,54.53z M76.29,73.22 c-2.36-2.06-4.82-4.26-6.03-5.74l-0.09,0.06c-2.85,1.93-6.34,3.24-11.14,3.23c-4.47-0.01-7.84-1.26-10.6-3.09 c-0.66-0.44-1.28-0.91-1.86-1.4c-1.37,1.72-4.43,4.31-7.17,6.63l-0.6,0.51C38.37,88.84,71.78,93.51,76.29,73.22L76.29,73.22 L76.29,73.22L76.29,73.22z"/></g></svg>
				</span>
				<span>Contact</span>
			</a></li>
            <li class="nav-label">ACCOUNT</li>
			<?php if(!$this->session->userdata('id')):?>
			<li><a class="nav-link" href="<?php echo base_url('mobile/account/login');?>">
				<span class="dz-icon">
					<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g></g><g><g><path d="M5,5h6c0.55,0,1-0.45,1-1v0c0-0.55-0.45-1-1-1H5C3.9,3,3,3.9,3,5v14c0,1.1,0.9,2,2,2h6c0.55,0,1-0.45,1-1v0 c0-0.55-0.45-1-1-1H5V5z"></path><path d="M20.65,11.65l-2.79-2.79C17.54,8.54,17,8.76,17,9.21V11h-7c-0.55,0-1,0.45-1,1v0c0,0.55,0.45,1,1,1h7v1.79 c0,0.45,0.54,0.67,0.85,0.35l2.79-2.79C20.84,12.16,20.84,11.84,20.65,11.65z"></path></g></g></svg>
				</span>
				<span>Login</span>
			</a></li>
			<?php endif;?>
			<?php if($this->session->userdata('id')):?>
			<li><a class="nav-link" href="<?php echo base_url('mobile/account/profile/'.$this->session->userdata('id'));?>">
				<span class="dz-icon">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v1c0 .55.45 1 1 1h14c.55 0 1-.45 1-1v-1c0-2.66-5.33-4-8-4z"></path></svg>
				</span>
				<span>Profile</span>
			</a></li>
			<li><a class="nav-link" href="<?php echo base_url('mobile/account/logout');?>">
				<span class="dz-icon">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="-49 141 512 512" aria-hidden="true"><path d="M207 372c-13.807 0-25-11.193-25-25V166c0-13.807 11.193-25 25-25s25 11.193 25 25v181c0 13.807-11.193 25-25 25z"></path><path d="M370.342 258.658c-27.847-27.847-61.558-47.693-98.342-58.419v52.84C339.785 279.251 388 345.096 388 422c0 99.804-81.196 181-181 181S26 521.804 26 422c0-76.904 48.215-142.749 116-168.921v-52.84c-36.784 10.726-70.494 30.572-98.342 58.419C.028 302.288-24 360.298-24 422S.028 541.712 43.658 585.342C87.289 628.972 145.298 653 207 653s119.712-24.028 163.342-67.658C413.972 541.712 438 483.702 438 422s-24.028-119.712-67.658-163.342z"></path></svg>
				</span>
				<span>Logout</span>
			</a></li>
			<li class="nav-label">FINANCE</li>
			<li><a class="nav-link" href="<?php echo base_url('mobile/order/statistic');?>">
				<span class="dz-icon">
					<svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 512 512"><g><g><path d="m108.5,400.3l77.2-112.8 81.7,78.8c13.7,11.6 27.3,3.1 30.9-3l135.6-194.3 4.9,65c0.8,10.7 9.8,18.9 20.3,18.9 12,0 21.2-10.7 20.4-22l-8.6-114.3c-0.9-11.2-10.6-19.7-21.9-18.8l-114.3,8.6c-11.2,0.8-19.7,10.6-18.8,21.9 0.8,11.2 10.6,19.6 21.9,18.8l65-4.9-124.2,178-81.9-78.9c-5-5.7-20-10.8-31,3.2l-73,106.6v57.9c6.1-0.3 12.1-3.3 15.8-8.7z"/><path d="M480.6,460.2H51.8V31.4c0-11.3-9.1-20.4-20.4-20.4C20.1,11,11,20.1,11,31.4v449.2c0,11.3,9.1,20.4,20.4,20.4h449.2    c11.3,0,20.4-9.1,20.4-20.4C501,469.3,491.9,460.2,480.6,460.2z"/></g></g></svg>
				</span>
				<span>Statistic</span>
			</a></li>
			<?php endif;?>
            <li class="nav-label">TERMS & CO</li>
            <li>
				<a href="<?php echo base_url('mobile/impressum');?>" class="nav-link">
					<span class="dz-icon">
					<svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 399 511.66"><path fill-rule="nonzero" d="M71.1 0h190.92c5.22 0 9.85 2.5 12.77 6.38L394.7 136.11c2.81 3.05 4.21 6.92 4.21 10.78l.09 293.67c0 19.47-8.02 37.23-20.9 50.14l-.09.08c-12.9 12.87-30.66 20.88-50.11 20.88H71.1c-19.54 0-37.33-8.01-50.22-20.9C8.01 477.89 0 460.1 0 440.56V71.1c0-19.56 8-37.35 20.87-50.23C33.75 8 51.54 0 71.1 0zm45.78 254.04c-8.81 0-15.96-7.15-15.96-15.95 0-8.81 7.15-15.96 15.96-15.96h165.23c8.81 0 15.96 7.15 15.96 15.96 0 8.8-7.15 15.95-15.96 15.95H116.88zm0 79.38c-8.81 0-15.96-7.15-15.96-15.96 0-8.8 7.15-15.95 15.96-15.95h156.47c8.81 0 15.96 7.15 15.96 15.95 0 8.81-7.15 15.96-15.96 15.96H116.88zm0 79.39c-8.81 0-15.96-7.15-15.96-15.96s7.15-15.95 15.96-15.95h132.7c8.81 0 15.95 7.14 15.95 15.95 0 8.81-7.14 15.96-15.95 15.96h-132.7zm154.2-363.67v54.21c1.07 13.59 5.77 24.22 13.99 31.24 8.63 7.37 21.65 11.52 38.95 11.83l36.93-.05-89.87-97.23zm96.01 129.11-43.31-.05c-25.2-.4-45.08-7.2-59.39-19.43-14.91-12.76-23.34-30.81-25.07-53.11l-.15-2.22V31.91H71.1c-10.77 0-20.58 4.42-27.68 11.51-7.09 7.1-11.51 16.91-11.51 27.68v369.46c0 10.76 4.43 20.56 11.52 27.65 7.11 7.12 16.92 11.53 27.67 11.53h256.8c10.78 0 20.58-4.4 27.65-11.48 7.13-7.12 11.54-16.93 11.54-27.7V178.25z"/></svg>
					</span>
                    <span>Impressum</span>
				</a>
			</li>
            <li>
				<a href="<?php echo base_url('mobile/datenschutz');?>" class="nav-link">
					<span class="dz-icon">
					<svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 399 511.66"><path fill-rule="nonzero" d="M71.1 0h190.92c5.22 0 9.85 2.5 12.77 6.38L394.7 136.11c2.81 3.05 4.21 6.92 4.21 10.78l.09 293.67c0 19.47-8.02 37.23-20.9 50.14l-.09.08c-12.9 12.87-30.66 20.88-50.11 20.88H71.1c-19.54 0-37.33-8.01-50.22-20.9C8.01 477.89 0 460.1 0 440.56V71.1c0-19.56 8-37.35 20.87-50.23C33.75 8 51.54 0 71.1 0zm45.78 254.04c-8.81 0-15.96-7.15-15.96-15.95 0-8.81 7.15-15.96 15.96-15.96h165.23c8.81 0 15.96 7.15 15.96 15.96 0 8.8-7.15 15.95-15.96 15.95H116.88zm0 79.38c-8.81 0-15.96-7.15-15.96-15.96 0-8.8 7.15-15.95 15.96-15.95h156.47c8.81 0 15.96 7.15 15.96 15.95 0 8.81-7.15 15.96-15.96 15.96H116.88zm0 79.39c-8.81 0-15.96-7.15-15.96-15.96s7.15-15.95 15.96-15.95h132.7c8.81 0 15.95 7.14 15.95 15.95 0 8.81-7.14 15.96-15.95 15.96h-132.7zm154.2-363.67v54.21c1.07 13.59 5.77 24.22 13.99 31.24 8.63 7.37 21.65 11.52 38.95 11.83l36.93-.05-89.87-97.23zm96.01 129.11-43.31-.05c-25.2-.4-45.08-7.2-59.39-19.43-14.91-12.76-23.34-30.81-25.07-53.11l-.15-2.22V31.91H71.1c-10.77 0-20.58 4.42-27.68 11.51-7.09 7.1-11.51 16.91-11.51 27.68v369.46c0 10.76 4.43 20.56 11.52 27.65 7.11 7.12 16.92 11.53 27.67 11.53h256.8c10.78 0 20.58-4.4 27.65-11.48 7.13-7.12 11.54-16.93 11.54-27.7V178.25z"/></svg>
					</span>
                    <span>Datenschutz</span>
				</a>
			</li>
			<li class="nav-label">Settings</li>
            <li class="nav-color" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">
                <a href="javascript:void(0);" class="nav-link">
                    <span class="dz-icon">                        
                        <svg class="color-plate" xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px" fill="#000000">
							<path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9c.83 0 1.5-.67 1.5-1.5 0-.39-.15-.74-.39-1.01-.23-.26-.38-.61-.38-.99 0-.83.67-1.5 1.5-1.5H16c2.76 0 5-2.24 5-5 0-4.42-4.03-8-9-8zm-5.5 9c-.83 0-1.5-.67-1.5-1.5S5.67 9 6.5 9 8 9.67 8 10.5 7.33 12 6.5 12zm3-4C8.67 8 8 7.33 8 6.5S8.67 5 9.5 5s1.5.67 1.5 1.5S10.33 8 9.5 8zm5 0c-.83 0-1.5-.67-1.5-1.5S13.67 5 14.5 5s1.5.67 1.5 1.5S15.33 8 14.5 8zm3 4c-.83 0-1.5-.67-1.5-1.5S16.67 9 17.5 9s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
						</svg>
                    </span>					
                    <span>Highlights</span>					
                </a>
            </li>
            <li>
                <div class="mode">
                    <span class="dz-icon">
                        <svg class="dark" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g></g><g><g><g><path d="M11.57,2.3c2.38-0.59,4.68-0.27,6.63,0.64c0.35,0.16,0.41,0.64,0.1,0.86C15.7,5.6,14,8.6,14,12s1.7,6.4,4.3,8.2 c0.32,0.22,0.26,0.7-0.09,0.86C16.93,21.66,15.5,22,14,22c-6.05,0-10.85-5.38-9.87-11.6C4.74,6.48,7.72,3.24,11.57,2.3z"/></g></g></g>
						</svg>
                    </span>					
                    <span class="text-dark">Dark Mode</span>
                    <div class="custom-switch">
                        <input type="checkbox" class="switch-input theme-btn" id="toggle-dark-menu">
                        <label class="custom-switch-label" for="toggle-dark-menu"></label>
                    </div>
                </div>
            </li>
		</ul>
		<div class="sidebar-bottom">
			<h6 class="name">FGTECH APP</h6>
			<p>Version 1.0</p>
        </div>
    </div>
    <!-- Sidebar End -->