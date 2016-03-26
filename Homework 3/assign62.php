<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            div.whole{
                margin-top: 5px;
            }
            div.header{
                margin: auto;
                text-align: center;
                margin-top: 20px;
            }
            h1.title{
                margin: auto;
            }
            div.content{
                margin-top: 22px;
                border: solid;
                border-width: 2px;
                width: 500px;
                margin-left: auto;
                margin-right: auto;
            }
            table.table{
                width: auto;
                border: hidden;
                padding-top: 10px;
            }
            p.info{
                padding-left: 20px;
                margin-top: 1px;
                margin-bottom: 2px;
            }
            p.sp{
                padding-left: 20px;
                font-style:italic;
            }
            td.link{
                text-align: center;
                height: 15px;
            }
            p.thelink{
                margin-top: 1px;
                margin-bottom: 12px;
            }
            div.search{
                margin-top: 40px;
                border: solid;
                border-width: 2px;
                width: 500px;
                margin-left: auto;
                margin-right: auto;
            }
            table.result{
                width: 500px;
                border: hidden;
                padding-top: 20px;
                padding-bottom: 26px;
            }
            tr.result{
                height: auto;
                text-align: center;
            }
            tr.result b{
                font-size: 20px;
            }
            tr.result img{
                width: 114px;
            }
            td.left{
                text-align: center;
            }
        </style>
        <script type="text/javascript">
            function inputValidation() {
                var street_address = document.getElementById("StreetAddress").value;
                
                if (street_address == ""){
                    alert("Please enter value for Street Address");
                    return false;
                }
                
            }
            function clearInput(){
                var street_address = document.getElementById("StreetAddress");
                street_address.removeAttribute("value");
                var city = document.getElementById("City");
                city.removeAttribute("value");
                var state = document.getElementById("State");
                var stateOpt =state.options[state.selectedIndex];
                stateOpt.removeAttribute("selected");
                var stateDefault = state.options[0];
                stateDefault.setAttribute("selected","");
                var temperature_F = document.getElementById("Fahrenheit");
                var temperature_C = document.getElementById("Celsius");
                temperature_C.removeAttribute("checked");
                var searchResult = document.getElementById("searchResult");
                var sR_parent = searchResult.parentNode;
                sR_parent.removeChild(searchResult);
            }
        </script>
    </head>
    <body>
    <?php
    $streetAddress="";
    $city = "";
    $state = "";
    $Fahrenheit_status = "checked";
    $Celsius_status = "unchecked";
    //if(isset($_POST["submit"])) {
        //$streetAddress = $_POST["StreetAddress"];
        
        //$enstreetAddress = urlencode($streetAddress);
       
        //$URL = "http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=".$enstreetAddress;
        
        
       
        //$urlContent = file_get_contents($URL);
        //$xmlFile = simplexml_load_string($urlContent);
        
        /*echo "<table border=1>";
        echo "<tr><td>Name</td><td>Symbol</td><td>Exchange</td><td>Details</td></tr>";
        
        $xmlFile=simplexml_load_file($URL);
        foreach($xmlFile->LookupResult as $item)
        {
        $symbol = $item->Symbol;
        $name = $item->Name;
        $exchange= $item->Exchange;
        echo "<tr><td>".$symbol."</td><td>".$name."</td><td>".$exchange."</td><td><a href="" >More Details</a></td></tr>";
        $k=1;
        }
        
        echo "</table>";*/
        
        $symbol=$_GET['symbol'];
        $forecastURL = "http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=$symbol";
        $forecastURLContent = file_get_contents($forecastURL);
        $forecastJson = json_decode($forecastURLContent);
        $status = $forecastJson->Status;
        $name = $forecastJson->Name;
        $symbol = $forecastJson->Symbol;
        $lastprice = $forecastJson->LastPrice;
        $change = $forecastJson->Change;
        $change = floor($change*100)/100;
        if($change<0){
            $changeImg="http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png";
        }
        else{
            $changeImg="http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png";
        }
        $changepercent = $forecastJson->ChangePercent;
        $changepercent = floor($changepercent*100)/100;
        if($changepercent<0){
            $changepercentImg="http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png";
        }
        else{
            $changepercentImg="http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png";
        }
        $timestamp = $forecastJson->Timestamp;
        
        $date=date_create($timestamp);
        $timestamp=date_format($date,"Y-m-d h:i A");
        
        $msdate = $forecastJson->MSDate;
        
        $marketcap = $forecastJson->MarketCap;
        $marketcap= $marketcap/1000000000;
        $marketcap=floor($marketcap*100)/100;
        $volume = $forecastJson->Volume;
        $volume= number_format($volume);
        $changeytd = $forecastJson->ChangeYTD;
        $changeytd=floor($changeytd*100)/100;
        if($changeytd<0){
            $changeytdImg="http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png";
        }
        else{
            $changeytdImg="http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png";
        }
        $changepercentytd = $forecastJson->ChangePercentYTD;
        $changepercentytd=floor($changepercentytd*100)/100;
        if($changepercentytd<0){
            $changepercentytdImg="http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png";
        }
        else{
            $changepercentytdImg="http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png";
        }
        $high = $forecastJson->High;
        $low = $forecastJson->Low;
        $open = $forecastJson->Open;
        
        
    //}
    ?>
        <div class="whole">
            <div class="header">
                <h1 class="title">Forecast Search</h1>
            </div>
            <div class="content">
            <form id="theForm" name="threeInfo" onsubmit="inputValidation()" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <table class="table" valign="middle">
                    <tr>
                        <td class="info">Stock Search </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="info">Street Address:*</p>
                        </td>
                        <td>
                            <input type="text" id="StreetAddress" name="StreetAddress" value="<?php echo $_GET['streetAddress']; ?> "  />
                        </td>
                    </tr>
                    
            
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" value="Search" onclick="return inputValidation() " />
                            <input type="reset" value="Clear" onclick="clearInput()"/>
                        </td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td class="link">
                            <a href="http://www.markit.com/product/markit-on-demand"><p class="thelink">Powered by Market On demand</p></a>
                        </td>
                    </tr>
                </table>
            </form>
            </div>
            <?php
            
            //if(isset($_GET["submit"])){
                echo "<div id='searchResult' class='search'><table class='result'>";
                    /*echo "<tr class='result'><td colspan='2'><b>".$name."</b></td></tr>";
                    echo "<tr class='result'><td colspan='2'><b>".$symbol."</b></td></tr>";
                    echo "<tr class='result'><td colspan='2'>"."<img title=$Icon_Value src=".$IconArray[$Icon_Value].">"."</td></tr>";*/
                    echo "<tr><td class='left'>"."Name"."</td><td>".$name."</td></tr>";
                    echo "<tr><td class='left'>"."Symbol"."</td><td>".$symbol."</td></tr>";
                    echo "<tr><td class='left'>"."Last Price"."</td><td>".$lastprice."</td></tr>";
                    echo "<tr><td class='left'>"."Change"."</td><td>".$change."<img src=".$changeImg." height=15px width=12px></td></tr>";
                    echo "<tr><td class='left'>"."Change Percent"."</td><td>".$changepercent."%"."<img src=".$changepercentImg." height=15px width=12px></td></tr>";
                    echo "<tr><td class='left'>"."Timestamp"."</td><td>".$timestamp."</td></tr>";
                    echo "<tr><td class='left'>"."Market Cap"."</td><td>".$marketcap." B"."</td></tr>";
                    echo "<tr><td class='left'>"."Volume"."</td><td>".$volume."</td></tr>";
                    echo "<tr><td class='left'>"."Change YTD"."</td><td>"."(".$changeytd.")"."<img src=".$changeytdImg." height=15px width=12px></td></tr>";
                    echo "<tr><td class='left'>"."Change Percent YTD"."</td><td>".$changepercentytd."<img src=".$changepercentytdImg." height=15px width=12px></td></tr>";
                    echo "<tr><td class='left'>"."High"."</td><td>".$high."</td></tr>";
                    echo "<tr><td class='left'>"."Low"."</td><td>".$low."</td></tr>";
                    echo "<tr><td class='left'>"."Open"."</td><td>".$open."</td></tr>";
                
                echo "</table></div>";
            
            //}
            ?>
        </div>
    <noncript>
    </body>
</html>