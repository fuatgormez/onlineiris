<rss xmlns:g="http://base.google.com/ns/1.0" xmlns:c="http://base.google.com/cns/1.0" version="2.0">
<channel>
 <title>IRISPICTURE</title>
 <link>https://www.irispicture.com/</link>
 <description>Dein IRIS, Dein FOTO</description>
 <?php foreach($products as $product):?>
  <item>
    <g:id><?php echo $product['product_id'] ?: ' ';?></g:id>
    <g:google_product_category><?php echo $product['category_sku'] ?: ' ';?></g:google_product_category>
    <g:title><?php echo ucwords(strtolower($product['category_name'] .' '.$product['product_name'])) ?: ' ';?></g:title>
    <g:description><?php echo strip_tags($product['description']) ?: ' ';?></g:description>
    <g:link><?php echo base_url('product/'.$this->slug->url($product['category_name']).'/'. $this->slug->url($product['product_name']).'/'.$product['id'] ?: ' '); ?></g:link>
    <g:image_link><?php echo base_url('public/uploads/product_photos/thumbnail/' . $product['thumbnail'] ?: ' ');?></g:image_link>
    <g:availability><?php echo $product['product_price'] > 0 ? "in stock" : "out of stock"; ?></g:availability>
    <g:price><?php echo $product['product_price'] ?: ' '; ?> EUR</g:price>
    <g:mpn><?php echo $product['product_id'] ?: ' ';?></g:mpn>
    <g:brand>IRISPICTURE</g:brand>
    <g:condition>new</g:condition>
    <g:product_category><?php echo ucwords(strtolower($product['category_name'])) ?: ' ';?></g:product_category>
  </item>
  <?php endforeach;?>
 </channel>
 </rss>