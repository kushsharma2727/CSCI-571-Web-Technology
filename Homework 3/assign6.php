<!DOCTYPE html>
<html>
    <head>
        <title>Homework 6</title>
        <style type="text/css">
            
            h1.title{
                margin: auto;
            }
            
            div.header{
                margin: auto;
                text-align: center;    
            }
            
            div.info_cont{
                margin-top: 22px;
                border: solid #ddd;
                border-width: 1px;
                width: 500px;
                background-color: #f1f1f1;
                margin-left: auto;
                margin-right: auto;
            }
            
            hr{
                border-color: #ddd;
                background-color: #ddd;
                
            }
            
            #check2{
                color: #aaa;
            }
            
            table.table{
                padding-top: 10px;
                width: 100%;
                border: hidden;
                border-bottom: 0px;
                text-align: center;    
            }
            
            
            #makebold{
                font-weight: bold;
            }
            
            table.table th{
                border-bottom: 0px;
                border-left: 0px;
                border-right: 0px;
            }
            
            th{
                font-style:italic;
                font-size: 34px;
                padding-left: 0px;
                font-weight: 10px;
            }
            
            
            #fail1,#fail2{
                text-align: center;
            }
            
			table.table td{
                border-left: 0px;
                border-bottom: 0px;
                border-right: 0px;
            }
			
            p.data{
                padding-left: 20px;
                margin-top: 1px;
                margin-bottom: 2px;
            }
            
            p.sp{
                padding-left: 20px;
                font-style:italic;
            }
            
            td.link{
                height: 15px;
                padding-left: 0px;
                font-size: 15px;
                margin-bottom: 12px;
            }
            
            div.stocksearch{
                margin-top: 40px;
                border-width: 2px;
                width: 500px;
                margin-left: auto;
                margin-right: auto;
            }
            
            table.out_res{
                width: 500px;
                padding-top: 20px;
                border: 1px solid #ddd;
                border-bottom: 1px solid #ddd;
                padding-bottom: 26px;
                border-collapse:collapse;
                background-color: #f1f1f1;
                
            }
            
            p.jump{
                margin-top: 1px;
                margin-bottom: 12px;
            }
            
            tr.out_res{
                height: auto;
                text-align: center;
            }
            
            tr.out_res b{
                 font-size: 20px;
            }
            
            tr.out_res img{
                width: 114px;
            }
            
            td.pichla{
                text-align: left;
                font-weight: bold;
            }
            
            #check1{
                color: #aaa;
            }
            
            th,td {
                border-bottom: 1px solid #ddd;
                border-left: 1px solid #ddd;
                border-right: 1px solid #ddd;
            }
            
            td.agla{
                text-align: center;
            }
            
        </style>
        <script type="text/javascript">
            
        function inputRemove(){
                
                var company_name = document.getElementById("CompanyName");
                company_name.removeAttribute("value");
                var alpha=document.getElementById("table_idone");
                document.getElementById("table_idone").innerHTML = "";     
            }
        
        </script>
    </head>
    <body>
    
    <?php
    $companyName="";
    $checkValue=1;
    
        if(isset($_GET["symbol"])) {

        $symbol=$_GET['symbol'];
        $saveSymbol=$symbol;
        $getstockURL = "http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=$symbol";
        $getstockURLContent = file_get_contents($getstockURL);
        $getstockJson = json_decode($getstockURLContent);
        $status = $getstockJson->Status;
        $saveStatus=$status;
            
    }
    ?>
        
            
            <div class="info_cont">
            
                <form id="myform" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                
                <table class="table">
                    <tr><th>Stock Search</th></tr>
                    <tr><td colspan="3"><hr style="color:#ddd"></td></tr>
                    <tr>
                        <td align="left">
                            &nbsp;&nbsp;Company Name or Symbol:
                            <input type="text" name="CompanyName" id="CompanyName" value="<?php if(isset($_GET["submit"]) || isset($_GET["symbol"])) { echo $_GET['CompanyName']; } ?>" required/>
                        </td>
                    </tr>
            
                    <tr>
                        <td>
                            <input type="submit" name="submit" value="Search"/>
                            <input type="reset" value="Clear" onclick="inputRemove()"/>
                        </td>
                    </tr>
                    <tr>
                        <td class='link'>
                            <a href="http://www.markit.com/product/markit-on-demand">
                                Powered by Markit On Demand
                            </a>
                        </td>
                    </tr>
                </table>
            </form>
            </div>
            
            <?php
            if(isset($_GET["submit"])) {
                echo "<div id='stockResult' class='stocksearch'>";
                echo "<table id ='table_idone' class='out_res'>";
                
                $CompanyName = $_GET["CompanyName"];
        
                $cocompanyName = urlencode($CompanyName);
       
                $URL = "http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=".$cocompanyName;
        
                $xmlFile=simplexml_load_file($URL);
        
                $c=count($xmlFile->LookupResult);
                
                if($c==0){
                echo "<tr id='fail1'><td>No Record has been found</td></tr>";
                }
        
                else
                {
                echo "<tr id='makebold'><td>Name</td><td>Symbol</td><td>Exchange</td><td>Details</td></tr>";        
                foreach($xmlFile->LookupResult as $item)
                {
                $symbol = $item->Symbol;
                $name = $item->Name;
                $exchange= $item->Exchange;
                echo "<tr><td>".$symbol."</td><td>".$name."</td><td>".$exchange."</td><td><a href=http://cs-server.usc.edu:26909/assign6.php?symbol=$symbol&CompanyName=$CompanyName>More Details</a></td></tr>";
                }
                
                }
                echo "</table></div>";
                }
            
            if(isset($_GET["symbol"])){
                
                echo "<div id='searchResultkanika' class='stocksearch'>";
                echo "<table id ='table_idone' class='out_res'>";
                    
                    if(preg_match('/Failure/',$status)){
                        echo "<tr id='fail2'><td>There is no stock information available</td></tr>";
                    }
                    else{
                    
                    $name = $getstockJson->Name;
                    $symbol = $getstockJson->Symbol;
                    $lastprice = $getstockJson->LastPrice;
                    $change = $getstockJson->Change;
                    $change = floor($change*100)/100;
                        
                    if($change>0){
                        $changeImg="http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png";
                    }
                    else{
                        $changeImg="http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png";
                    }
                    $changepercent = $getstockJson->ChangePercent;
                    $changepercent = floor($changepercent*100)/100;
                    if($changepercent>0){
                    
                        $changepercentImg="http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png";
                    }
                    else{
                        $changepercentImg="http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png";
                    }
                    
                        
                    $timestamp = $getstockJson->Timestamp;
                    $date=date_create($timestamp);
                    $timestamp=date_format($date,"Y-m-d h:i A");
        
                    $msdate = $getstockJson->MSDate;
        
                $marketcap = $getstockJson->MarketCap;
                $marketcap= $marketcap/1000000000;
                $marketcap=floor($marketcap*100)/100;
                $volume = $getstockJson->Volume;
                $volume= number_format($volume);
                $changeytd = $getstockJson->ChangeYTD;
                $changeytd=floor($changeytd*100)/100;
                        
                if($changeytd>0){
                    
                    $changeytdImg="http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png";
                }
                else{
                    $changeytdImg="http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png";
                }
                        
                $changepercentytd = $getstockJson->ChangePercentYTD;
                $changepercentytd=floor($changepercentytd*100)/100;
                
                if($changepercentytd>0){
                    
                    $changepercentytdImg="http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png";
                }
                else{
                    $changepercentytdImg="http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png";
                }
                
                $high = $getstockJson->High;
                $low = $getstockJson->Low;
                $open = $getstockJson->Open;
                
                    
                    echo "<tr><td class='pichla'>"."Name"."</td><td class='agla'>".$name."</td></tr>";
                    echo "<tr><td class='pichla'>"."Symbol"."</td><td class='agla'>".$symbol."</td></tr>";
                    echo "<tr><td class='pichla'>"."Last Price"."</td><td class='agla'>".$lastprice."</td></tr>";
                    echo "<tr><td class='pichla'>"."Change"."</td><td class='agla'>".$change."<img src=".$changeImg." height=15px width=12px></td></tr>";
                    echo "<tr><td class='pichla'>"."Change Percent"."</td><td class='agla'>".$changepercent."%"."<img src=".$changepercentImg." height=15px width=12px></td></tr>";
                    echo "<tr><td class='pichla'>"."Timestamp"."</td><td class='agla'>".$timestamp."</td></tr>";
                    echo "<tr><td class='pichla'>"."Market Cap"."</td><td class='agla'>".$marketcap." B"."</td></tr>";
                    echo "<tr><td class='pichla'>"."Volume"."</td><td class='agla'>".$volume."</td></tr>";
                    echo "<tr><td class='pichla'>"."Change YTD"."</td><td class='agla'>"."(".$changeytd.")"."<img src=".$changeytdImg." height=15px width=12px></td></tr>";
                    echo "<tr><td class='pichla'>"."Change Percent YTD"."</td><td class='agla'>".$changepercentytd."%"."<img src=".$changepercentytdImg." height=15px width=12px></td></tr>";
                    echo "<tr><td class='pichla'>"."High"."</td><td class='agla'>".$high."</td></tr>";
                    echo "<tr><td class='pichla'>"."Low"."</td><td class='agla'>".$low."</td></tr>";
                    echo "<tr><td class='pichla'>"."Open"."</td><td class='agla'>".$open."</td></tr>";
                    }
                echo "</table></div>";
            
            }
            
            ?>
    <noncript>
    </body>
</html>