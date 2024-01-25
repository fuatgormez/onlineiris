<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Print a Label</title>
    <script src="http://labelwriter.com/software/dls/sdk/js/DYMO.Label.Framework.latest.js" type="text/javascript" charset="UTF-8"> </script>
    <!--<script src="../../../dymo.label.framework.js" type="text/javascript" charset="UTF-8"> </script>-->
    <script src="1http://www.labelwriter.com/software/dls/sdk/samples/js/PrintLabel/PrintLabel.js" type="text/javascript" charset="UTF-8"> </script>
</head>

<body>
    <h1>DYMO Label Framework JavaScript Library Samples: Print Label</h1>

    <div id="textDiv">
        <label for="textTextArea">Label text:</label><br />
        <textarea name="textTextArea" id="textTextArea" rows="5" cols="40"> <?php echo $print["label"]; ?> </textarea>
    </div>

    <div id="printDiv">
        <button id="printButton">Print</button>
    </div>

    <script>
        //wait for DOM ready...
        document.addEventListener('DOMContentLoaded', () => {

            //...get the button
            let printButton = document.querySelector('#printButton');

            //...bind the click event
            printButton.addEventListener('click', () => {


                try {
                    // open label
                    var labelXml = '<?xml version="1.0" encoding="utf-8"?>\
    <DieCutLabel Version="8.0" Units="twips">\
        <PaperOrientation>Landscape</PaperOrientation>\
        <Id>Address</Id>\
        <PaperName>30252 Address</PaperName>\
        <DrawCommands/>\
        <ObjectInfo>\
            <TextObject>\
                <Name>Text</Name>\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                <LinkedObjectName></LinkedObjectName>\
                <Rotation>Rotation0</Rotation>\
                <IsMirrored>False</IsMirrored>\
                <IsVariable>True</IsVariable>\
                <HorizontalAlignment>Left</HorizontalAlignment>\
                <VerticalAlignment>Middle</VerticalAlignment>\
                <TextFitMode>ShrinkToFit</TextFitMode>\
                <UseFullFontHeight>True</UseFullFontHeight>\
                <Verticalized>False</Verticalized>\
                <StyledText/>\
            </TextObject>\
            <Bounds X="332" Y="150" Width="4455" Height="1260" />\
        </ObjectInfo>\
    </DieCutLabel>';
                    var label = dymo.label.framework.openLabelXml(labelXml);

                    // set label text
                    label.setObjectText("Text", textTextArea.value);

                    // select printer to print on
                    // for simplicity sake just use the first LabelWriter printer
                    var printers = dymo.label.framework.getPrinters();
                    if (printers.length == 0)
                        throw "No DYMO printers are installed. Install DYMO printers.";

                    var printerName = "";
                    for (var i = 0; i < printers.length; ++i) {
                        var printer = printers[i];
                        if (printer.printerType == "LabelWriterPrinter") {
                            printerName = printer.name;
                            break;
                        }
                    }

                    if (printerName == "")
                        throw "No LabelWriter printers found. Install LabelWriter printer";

                    // finally print the label
                    label.print(printerName);
                } catch (e) {
                    alert(e.message || e);
                }


                function initTests() {
                    if (dymo.label.framework.init) {
                        //dymo.label.framework.trace = true;
                        dymo.label.framework.init(onload);
                    } else {
                        onload();
                    }
                }


            }, false);

            //...trigger the click event on page enter
            printButton.click();

        }, false);

        // sleep(3000);
        // window.top.close();

    </script>
</body>

</html>