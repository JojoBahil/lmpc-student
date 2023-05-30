<?php

    session_start();
    include('other/dbconnect.php');
    header("Content-Type:text/html; charset=ISO-8859-1");

    if(!$_SESSION['awardeenumber']){
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LMPC Application Portal</title>
        <link rel="icon" href="image/lmpcicon.ico">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/Footer-Basic.css">
        <link rel="stylesheet" href="assets/css/instruction.css">
        <link rel="stylesheet" href="assets/css/all.min.css">
    </head>
    <body style="background-image:url('image/background2.webp');background-attachment: fixed; background-position: center;">
        <div><br><br>
            <div class="container" style="background-color:rgba(255,255,255,0.9); color:#737373; padding-top:20px;  padding-bottom:20px; border-radius:7px;">
                <div>
                    <div style="background-image:url('image/heading.png');background-repeat: no-repeat;background-size: 500px 43px;padding:10px;padding-left:40px;color:white;">
                        <h4><b>TERMS AND CONDITIONS
                        </b></h4>
                    </div>
                </div>
                <div>
                    <div class="row" style="margin-left:70px;margin-right:60px; font-size:12px">
                        <strong>TERMS AND CONDITIONS FOR THE USE OF THE UNIFAST PORTAL FOR THE LANDBANK MASTERCARD PREPAID CARD (LMPC) APPLICATION</strong>
                    </div>
                    <div class="row">&nbsp;</div>
                    <div class="row">                        
                        <div class="col">
                            <ol style="margin-left:50px;margin-right:60px; font-size:11px">
                                <li>
                                    Pursuant to the provisions on the Guidelines of Tertiary Education Subsidy (TES) Program under Joint Memorandum Circular No. 9, Series of 2019 by the CHED-UniFAST and the Department of Budget and Management, specifically under rules on the disbursement of TES grants, requires the issuance of LANDBANK Mastercard Prepaid Card (LMPC) to student-grantees.
                                </li>
                                <li>
                                    Prior to the issuance of the LMPC, the student-grantees are required to register personal information using the UniFAST Portal for the LMPC application.
                                </li>
                                <li>
                                    The student-grantee agrees to be bound by the rules and regulations, and official issuances applicable to this service now existing or which may hereinafter be issued, as well as such other terms and conditions governing the use of this service.
                                </li>
                                <li>Features
                                    <ol type="a">
                                        <li>The UniFAST Portal for the LANDBANK Mastercard Prepaid Card (LMPC) Application was created and solely intended for the TES student-grantees.  In order to directly receive your monthly stipend for the TES grant through this feature, you must be a LMPC holder.  This Portal's main purpose is to help you accomplish the form required by the Bank for card registration without queuing in their branch and save your time.</li>
                                        <li>The UniFAST Portal is available 24/7 except for any cause beyond the control of UniFAST such as failure on internet connectivity and other related problems.</li>
                                    </ol>
                                </li>
                                <li>
                                    Online Portal Rules
                                    <ol type="a">
                                        <li>You are allowed to fill-out the LMPC enrollment form online and complete the same within five (5) days upon the activation of the user credentials (username and password).</li>
                                        <li>You are allowed to save partially completed online enrolment form and subsequently access and finalize the same within the above-mentioned period.</li>
                                        <li>Incomplete online enrollment will not be processed.</li>
                                    </ol>
                                </li>
                                <li>
                                    Data Privacy
                                    <ol type="a">
                                        <li>In connection with my application for LANDBANK Mastercard Prepaid Card under the Tertiary Education Subsidy (TES) Program, I authorize Land Bank of the Philippines its subsidiaries agents, representatives, and outsourced service providers ("LANDBANK"), the Commission on Higher Education ("CHED"), and the Unified Student Financial Assistance System for Tertiary Education ("UniFAST"), to collect, process update or disclose personal information about me/us in accordance with the Data Privacy Act, its Implementing Rules and Regulations (IRR), Bank's Data Privacy Statement, and bank secrecy laws, to verify, my/our personal information from any person or entity that the Bank may deem necessary including, but not limited to, credit bureaus, financial institutions, and government authorities, to establish, confirm, review or update my/our record, manage my/our account and/or services provided to me/us, to conduct customer risk, capacity and suitability assessment, product development and audit, and other legitimate business purposes, and to comply with its reporting obligations under applicable laws, rules and regulations.</li>
                                        <li>I agree to hold LANDBANK, CHED, and UniFAST and the persons or entities from whom it may obtain, or with whom it may disclose or verify my/our personal information free and harmless from any liability arising from the use of any information.</li>
                                        <li>I confirm that I am aware that under the Data Privacy Act, I have (a) the right to withdraw the consent hereby given or to object to the processing of my personal information provided there is no other legal ground or overriding legitimate interest to the processing thereof; (b) right to reasonable access, (c) right to rectification, and (d) right to erasure or blocking of my personal information subject, however, to the conditions for the legitimate exercise of the said rights under the Data Privacy Act and its IRR, and subject further to the right of the Bank to terminate the product or service availed by me should I withdraw my consent or request the removal of my personal information.</li>
                                    </ol>
                                </li>
                            </ol>
                        </div>
                    </div><br><br>
                    <div class="row">
                        <div class="col">
                            <form action = "other/functions.php" method = "POST" style="width:303.328;">  
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col" style="text-align:center"><button class="btn btn-primary save" name="btn_agree" type="submit" style="width:110px;margin-right:15px;">Agree</button><button class="btn btn-success save" type="submit" style="width:110px;" name="btn_disagree">Log out</button></div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            include('footer.php');
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="assets/js/all.min.js"></script>
    </body>
</html>
