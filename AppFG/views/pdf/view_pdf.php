<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div style="margin-top:10px; padding-top:10px"></div>
    <?php if ($order_item > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th width="75">Artikel Nr.</th>
                    <th width="350">Bezeichnung</th>
                    <th width="15">Menge</th>
                    <th width="95">Einzel</th>
                    <th width="95" align="right">Gesamt</th>
                </tr>
            </thead>
            <tbody>
                <!-- ITEMS HERE -->
                <?php foreach ($order_item as $item) : ?>
                    <tr>
                        <td><?php echo @$item['item_product_id']; ?></td>
                        <td>Gutschein für: <?php echo @$item['item_name']; ?><br> <?php echo !empty(@$item['item_uniqid']) ? "Transfer Code:" . @$item['item_uniqid'] : ''; ?></td>
                        <td align="center"><?php echo @$item['item_qty']; ?></td>
                        <td align="center"><?php echo number_format($item['item_price'], 2); ?></td>
                        <td align="right"><?php echo number_format(@$item['item_qty'] * @$item['item_price'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
                <!-- END ITEMS HERE -->
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>&nbsp;</td>
                    <td align="right" class="cost">&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Zwischensumme</td>
                    <td align="right" class="cost"><?php echo $order['store_currency_icon'];?><?php echo @$o_zwischensumme; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Bereit bezahlt</td>
                    <td align="right" class="cost"><?php echo $order['store_currency_icon'];?><?php echo @$o_bereit_bezahlt; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Rabattbetrag</td>
                    <td align="right" class="cost"><?php echo $order['store_currency_icon'];?><?php echo @$o_rabattbetrag; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Versandkosten</td>
                    <td align="right" class="cost"><?php echo $order['store_currency_icon'];?><?php echo @$o_shipping; ?></td>
                </tr>
                <?php if ($order_item_updated == NULL) : ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Zu Zahlen</td>
                        <td align="right" class="cost"><?php echo $order['store_currency_icon'];?><?php echo @$o_zu_zahlen; ?></td>
                    </tr>
                <?php endif; ?>
            </tfoot>
        </table>
    <?php endif; ?>

    <?php if ($order_item_updated != NULL) : ?>
        <div style="text-align: left; margin-top:20px;">______________________________________________________________________________________________________________________________</div>
        <div style="text-align: left; margin-top:10px;">UPDATE ON PLACE</div>
        <div style="clear: both; margin: 0pt; padding: 0pt; "></div>
        <table>
            <thead>
                <tr>
                    <th width="75">Artikel Nr.</th>
                    <th width="350">Bezeichnung</th>
                    <th width="15">Menge</th>
                    <th width="95">Einzel</th>
                    <th width="95" align="right">Gesamt</th>
                </tr>
            </thead>
            <tbody>
                <!-- ITEMS HERE -->

                <?php foreach ($order_item_updated as $item_updated) : ?>
                    <tr>
                        <td>U - <?php echo @$item_updated['item_id']; ?></td>
                        <td>Gutschein für: <?php echo @$item_updated['item_name']; ?><br> <?php echo !empty(@$item_updated['item_uniqid']) ? "Transfer Code:" . @$item_updated['item_uniqid'] : ''; ?></td>
                        <td align="center"><?php echo @$item_updated['item_qty']; ?></td>
                        <td align="center"><?php echo @$item_updated['item_price']; ?></td>
                        <td align="right"><?php echo @$item_updated['item_qty'] * @$item_updated['item_price']; ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php if ($order_item_extra > 0) : ?>
                    <?php foreach ($order_item_extra as $item_extra) : ?>
                        <tr>
                            <td>E - <?php echo @$item_extra['item_id']; ?></td>
                            <td><?php echo @$item_extra['item_name']; ?><br> <?php echo !empty(@$item_extra['item_uniqid']) ? "Transfer Code:" . @$item_extra['item_uniqid'] : ''; ?></td>
                            <td align="center"><?php echo @$item_extra['item_qty']; ?></td>
                            <td align="center"><?php echo @$item_extra['item_price']; ?></td>
                            <td align="right"><?php echo @$item_extra['item_qty'] * @$item_extra['item_price']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <tr>
                    <td>-</td>
                    <td>With name</td>
                    <td align="center"><?php echo @$order_item_with_name->v_count; ?></td>
                    <td align="center">-</td>
                    <td align="right"><?php echo @$order_item_with_name->v_sum; ?></td>
                </tr>
                <!-- END ITEMS HERE -->
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>&nbsp;</td>
                    <td align="right" class="cost">&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Zwischensumme</td>
                    <td align="right" class="cost"><?php echo $order['store_currency_icon'];?><?php echo @$u_zwischensumme; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Bereit bezahlt</td>
                    <td align="right" class="cost"><?php echo $order['store_currency_icon'];?><?php echo @$u_bereit_bezahlt; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Rabattbetrag</td>
                    <td align="right" class="cost"><?php echo $order['store_currency_icon'];?><?php echo @$u_rabattbetrag; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Versandkosten</td>
                    <td align="right" class="cost"><?php echo $order['store_currency_icon'];?><?php echo @$u_shipping; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Zu Zahlen</td>
                    <td align="right" class="cost"><?php echo $order['store_currency_icon'];?><?php echo @$u_zu_zahlen; ?></td>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>


    <div style="text-align: left; margin-top:10px;">______________________________________________________________________________________________________________________________</div>


    <div style="float: right; width: 32%; margin-top:10px;">
        <strong>Gesamt zu zahlen: <?php echo @$zahlen; ?></strong><br />
        <small>Alle Preise inkl. MwSt.</small>
    </div>
    <div style="clear: both; margin: 0pt; padding: 0pt; "></div>

    <div style="text-align: left; margin-top:25px">Vielen Dank Für Dein Interesse an unseren Dientleistungen.</div>
    <div style="text-align: left; margin-top:5px">Der von Dir gekaufte Gutschein kann für Upgrades von höherwertigen Produkten am Standort oder über den Kundenservice verwendet und angerechnet werden.</div>
    <div style="text-align: left; margin-top:5px">Sofern eine offene Summe besteht, ist diese innerhalb von 14 Tagen zu beglichen.</div>
</body>

</html>