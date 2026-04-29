<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Official Certificate - <?= esc($record['registration_no']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=Noto+Sans+Devanagari:wght@400;700;900&family=Cinzel:wght@700;900&family=Alex+Brush&display=swap" rel="stylesheet">
    <style>
        :root { --gold: #c5a059; --dark: #1a1a1a; --mp-blue: #1e3a8a; --mp-orange: #f97316; }
        * { margin:0; padding:0; box-sizing: border-box; }
        body { background: #f1f5f9; margin: 0; padding: 0; font-family: 'Inter', sans-serif; min-height: 100vh; }
        .certificate {
            width: 850px; padding: 60px; background: white; margin: 50px auto; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.15); border: 1px solid #ddd; 
            min-height: 1100px; position: relative; overflow: hidden;
        }

        /* MP Style Header */
        .mp-header { width: 100%; text-align: center; border-bottom: 2px solid #334155; padding-bottom: 25px; margin-bottom: 40px; position: relative; }
        .mp-header h1 { width: 100%; font-family: 'Noto Sans Devanagari', sans-serif; font-size: 2.8rem; color: #1e293b; margin-bottom: 5px; text-align: center; font-weight: 800; }
        .mp-header p { font-size: 1rem; font-weight: 700; color: #475569; margin: 0; }
        
        /* Content Area */
        .cert-title { width: 100%; font-size: 2.2rem; text-align: center; margin: 30px 0; font-weight: 900; color: #1e293b; display: block; font-family: 'Noto Sans Devanagari', sans-serif; }
        .cert-body { width: 100%; color: #1e293b; font-size: 1.25rem; text-align: left; }
        
        .details-box { border: 1.5px solid #cbd5e1; border-radius: 15px; padding: 40px; background: #fff; margin-top: 30px; }
        .detail-row { margin-bottom: 20px; display: grid; grid-template-columns: 300px 40px 1fr; align-items: start; width: 100%; }
        .detail-row:last-child { margin-bottom: 0; }
        .detail-label { font-weight: 700; color: #475569; font-size: 1.15rem; }
        .detail-colon { font-weight: 900; color: #1e293b; text-align: left; font-size: 1.3rem; }
        .detail-value { font-weight: 800; color: #000; font-size: 1.4rem; word-break: break-word; line-height: 1.4; }

        @media print {
            body { background: white !important; padding: 0 !important; }
            .no-print-sidebar { display: none !important; }
            .certificate { margin: 0 auto !important; box-shadow: none !important; border: none !important; border-radius: 0 !important; page-break-after: always; }
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body>
    <?php 
        $lang = strtolower(trim($lang ?? 'bilingual')); 
        $configs = [];
        if ($lang === 'hi' || $lang === 'bilingual') $configs[] = ['lang' => 'hi'];
        if ($lang === 'en' || $lang === 'bilingual') $configs[] = ['lang' => 'en'];
    ?>

    <div class="no-print-sidebar" style="position: fixed; top: 30px; right: 30px; width: 190px; background: #fff; padding: 25px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.12); z-index: 2147483647; display: flex; flex-direction: column; gap: 12px; border: none;">
        <div style="font-weight: 800; color: #1e3a8a; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; text-align: center;">OUTPUT PREFERENCE</div>
        
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <a href="javascript:void(0)" onclick="setLang('hi')" 
               style="text-decoration: none; padding: 10px; border-radius: 50px; font-weight: 700; font-size: 0.85rem; text-align: center; transition: all 0.3s; cursor: pointer;
               background: <?= $lang == 'hi' ? '#1e293b' : '#f1f5f9' ?>; color: <?= $lang == 'hi' ? '#fff' : '#1e3a8a' ?>;">
               Hindi Copy
            </a>
            <a href="javascript:void(0)" onclick="setLang('en')" 
               style="text-decoration: none; padding: 10px; border-radius: 50px; font-weight: 700; font-size: 0.85rem; text-align: center; transition: all 0.3s; cursor: pointer;
               background: <?= $lang == 'en' ? '#1e293b' : '#f1f5f9' ?>; color: <?= $lang == 'en' ? '#fff' : '#1e3a8a' ?>;">
               English Copy
            </a>
            <a href="javascript:void(0)" onclick="setLang('bilingual')" 
               style="text-decoration: none; padding: 10px; border-radius: 50px; font-weight: 700; font-size: 0.85rem; text-align: center; transition: all 0.3s; cursor: pointer;
               background: <?= $lang == 'bilingual' ? '#1e293b' : '#f1f5f9' ?>; color: <?= $lang == 'bilingual' ? '#fff' : '#1e3a8a' ?>;">
               Both (2 Copies)
            </a>
        </div>
        
        <div style="margin: 20px 0; height: 1px; background: #eee;"></div>
        
        <button onclick="window.print()" style="cursor: pointer; background: #f97316; color: white; border: none; padding: 12px; border-radius: 50px; font-weight: 800; font-size: 0.85rem; width: 100%; box-shadow: 0 4px 15px rgba(249,115,22,0.3);">
            PRINT NOW
        </button>
    </div>

    <?php foreach($configs as $config): 
        $currentLang = $config['lang'];
        $isIncome = (strtolower(trim($record['type'] ?? '')) === 'income' || strpos($record['registration_no'] ?? '', 'INC') !== false);
        $isBirth = (strtolower(trim($record['type'] ?? '')) === 'birth');
        $isDeath = (strtolower(trim($record['type'] ?? '')) === 'death');
        $isCaste = (strtolower(trim($record['type'] ?? '')) === 'caste' || strpos($record['registration_no'] ?? '', 'CST') !== false);
        $isDomicile = (strtolower(trim($record['type'] ?? '')) === 'domicile' || strpos($record['registration_no'] ?? '', 'DOM') !== false);
    ?>

    <div class="certificate">
        <!-- WATERMARK -->
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.04; z-index: 0; pointer-events: none;">
            <div style="width: 550px; height: 550px; border: 20px double #1e3a8a; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 15rem; color: #1e3a8a; font-weight: 900;">
                <span><?= $currentLang == 'en' ? ($isIncome ? 'INC' : ($isBirth ? 'BIR' : ($isDeath ? 'DTH' : ($isCaste ? 'CST' : 'DOM')))) : 'म.प्र.' ?></span>
            </div>
        </div>

        <?php if($isIncome): ?>
            <!-- REAL MP GOVT STYLE INCOME CERTIFICATE -->
            <style>
                .income-cert { border: 4px double #1e3a8a; padding: 40px !important; position: relative; }
                .govt-emblem { width: 90px; height: 90px; margin: 0 auto 10px; border: 2px solid #1e3a8a; border-radius: 50%; padding: 5px; background: #fff; display: flex; align-items: center; justify-content: center; position: relative; z-index: 2; }
                .govt-emblem img { width: 100%; height: 100%; object-fit: contain; }
                .state-watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 450px; opacity: 0.05; pointer-events: none; z-index: 0; }
                .office-heading { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1e3a8a; padding-bottom: 15px; position: relative; z-index: 2; }
                .office-heading h1 { font-size: 2rem; color: #1e3a8a; margin: 0; font-weight: 800; }
                .office-heading h2 { font-size: 1rem; color: #475569; margin: 5px 0 0; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
            </style>

            <div class="income-cert" style="min-height: 1050px;">
                <!-- STATE WATERMARK -->
                <div class="state-watermark">
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" style="fill: #1e3a8a;">
                        <circle cx="100" cy="100" r="95" fill="none" stroke="#1e3a8a" stroke-width="2"/>
                        <circle cx="100" cy="100" r="85" fill="none" stroke="#1e3a8a" stroke-width="1"/>
                        <text x="50%" y="45%" dominant-baseline="middle" text-anchor="middle" font-size="20" font-weight="900" fill="#1e3a8a">मध्यप्रदेश शासन</text>
                        <text x="50%" y="65%" dominant-baseline="middle" text-anchor="middle" font-size="12" font-weight="700" fill="#1e3a8a">GOVT OF M.P.</text>
                    </svg>
                </div>

                <div class="govt-emblem">
                    <div style="text-align: center; color: #1e3a8a; font-weight: 900; line-height: 1.1; font-size: 0.65rem;"> म.प्र. <br> शासन </div>
                </div>

                <div class="office-heading">
                    <h1>मध्यप्रदेश शासन</h1>
                    <h2>कार्यालय ग्राम पंचायत बोदरली (बुरहानपुर)</h2>
                    <div style="font-size: 0.8rem; font-weight: 800; color: #64748b; margin-top: 5px;">पंजीयन क्रमांक: <?= esc($record['registration_no']) ?> | दिनांक: <?= date('d/m/Y', strtotime($record['created_at'])) ?></div>
                </div>

                <div style="text-align: center; margin: 30px 0;">
                    <div style="display: inline-block; border: 2px solid #1e3a8a; padding: 10px 40px; border-radius: 4px; background: #f8fafc;">
                        <h3 style="font-size: 1.8rem; color: #1e3a8a; margin: 0; font-weight: 900; text-transform: uppercase; letter-spacing: 2px;">
                            <?= $currentLang == 'hi' ? 'आय प्रमाण-पत्र' : 'INCOME CERTIFICATE' ?>
                        </h3>
                    </div>
                </div>

                <div class="cert-body" style="position: relative; z-index: 2;">
                    <p style="text-indent: 50px; margin-bottom: 40px; line-height: 2.2; font-size: 1.25rem; text-align: justify; color: #0f172a;">
                        <?php if($currentLang == 'hi'): ?>
                        यह प्रमाणित किया जाता है कि, संबंधित राजस्व कार्यालय के प्रतिवेदन एवं ग्राम पंचायत के उपलब्ध अभिलेखों के आधार पर, श्री/श्रीमती <b><?= esc($record['person_name']) ?></b> पुत्र/पुत्री/पत्नी श्री <b><?= esc($record['father_mother_name']) ?></b>, वार्ड क्रमांक <b><?= esc($record['village_ward'] ?? '07') ?></b>, ग्राम पंचायत <b>बोदरली</b>, तहसील बुरहानपुर, जिला बुरहानपुर के निवासी हैं। आपकी समस्त स्रोतों से कुल वार्षिक आय निम्नानुसार दर्ज है:
                        <?php else: ?>
                        This is to certify that, based on the revenue record reports and available records of the Gram Panchayat, Mr./Ms. <b><?= esc($record['person_name']) ?></b> S/o D/o W/o Mr. <b><?= esc($record['father_mother_name']) ?></b>, Resident of Ward No. <b><?= esc($record['village_ward'] ?? '07') ?></b>, Gram Panchayat <b>Bodarli</b>, Tahsil Burhanpur, District Burhanpur, is an inhabitant. Your total annual income from all sources is recorded as follows:
                        <?php endif; ?>
                    </p>

                    <div class="details-box" style="border: 2px solid #1e3a8a; background: #fff; padding: 0; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                        <table style="width: 100%; border-collapse: collapse; font-size: 1.15rem;">
                            <tr style="border-bottom: 2px solid #f1f5f9;">
                                <td style="padding: 25px 40px; font-weight: 700; color: #475569; width: 350px;">कुल वार्षिक आय (अंकों में)</td>
                                <td style="padding: 12px; font-weight: 800; color: #1e3a8a; font-size: 2.4rem;">₹ <?= number_format($record['annual_income'] ?? 0, 0) ?></td>
                            </tr>
                            <tr style="border-bottom: 2px solid #f1f5f9;">
                                <td style="padding: 25px 40px; font-weight: 700; color: #475569;">शब्दों में</td>
                                <td style="padding: 25px 40px; font-weight: 900; color: #1e3a8a;">
                                    <?php 
                                        if($currentLang == 'hi') { $nf = new NumberFormatter("hi", NumberFormatter::SPELLOUT); echo "रुपये " . $nf->format($record['annual_income'] ?? 0) . " मात्र"; }
                                        else { $nf = new NumberFormatter("en", NumberFormatter::SPELLOUT); echo "Rupees " . ucwords($nf->format($record['annual_income'] ?? 0)) . " Only"; }
                                    ?>
                                </td>
                            </tr>
                            <tr style="border-bottom: 2px solid #f1f5f9;">
                                <td style="padding: 25px 40px; font-weight: 700; color: #475569;">वित्तीय वर्ष</td>
                                <td style="padding: 25px 40px; font-weight: 800; color: #334155;"><?= esc($record['financial_year']) ?></td>
                            </tr>
                            <tr>
                                <td style="padding: 25px 40px; font-weight: 700; color: #475569;">आय का मुख्य स्रोत</td>
                                <td style="padding: 25px 40px; font-weight: 800; color: #334155; text-transform: uppercase;"><?= esc($record['profession']) ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <p style="margin-top: 30px; font-size: 0.95rem; color: #64748b; font-style: italic; line-height: 1.5;">
                        * यह प्रमाण-पत्र आवेदक द्वारा प्रस्तुत जानकारी एवं स्थानीय जांच के आधार पर जारी किया गया है। इसकी सत्यता की जांच संबंधित कार्यालय से की जा सकती है।
                    </p>
                </div>

                <div class="cert-footer" style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 80px; position: relative; z-index: 2;">
                    <div style="text-align: center;">
                        <div id="qr-verify-<?= $record['id'] ?>-<?= $currentLang ?>" style="padding: 8px; background: white; border: 2px solid #1e3a8a; border-radius: 8px; margin-bottom: 8px; display: inline-block;"></div>
                        <div style="font-size: 0.75rem; color: #1e3a8a; font-weight: 800;">VERIFY DOCUMENT</div>
                        <script>
                            window.addEventListener('load', function() {
                                new QRCode(document.getElementById("qr-verify-<?= $record['id'] ?>-<?= $currentLang ?>"), {
                                    text: "<?= base_url('verify-id/' . $record['registration_no']) ?>",
                                    width: 100,
                                    height: 100,
                                    colorDark : "#1e3a8a",
                                    colorLight : "#ffffff",
                                    correctLevel : QRCode.CorrectLevel.M
                                });
                            });
                        </script>
                    </div>
                    
                    <div style="position: relative; width: 380px; text-align: center;">
                        <!-- OFFICIAL WET STAMP EFFECT -->
                        <div style="position: absolute; top: -85px; left: 50%; transform: translateX(-50%) rotate(-12deg); width: 160px; height: 160px; border: 4px double rgba(30, 58, 138, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; text-align: center; color: rgba(30, 58, 138, 0.3); font-size: 0.85rem; font-weight: 900; line-height: 1.3; pointer-events: none; z-index: 0;">
                            राजस्व विभाग<br><b>ग्राम पंचायत बोदरली</b><br>मध्यप्रदेश शासन
                        </div>
                        
                        <div style="border-top: 2.5px solid #1e3a8a; padding-top: 15px; position: relative; z-index: 2;">
                            <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 8px;">
                                <div style="font-size: 1rem; font-weight: 800; color: #1e3a8a; font-family: 'Noto Sans Devanagari', sans-serif;">सचिव, ग्राम पंचायत बोदरली (बुरहानपुर)</div>
                                <div style="width: 1.5px; height: 20px; background: #1e3a8a; opacity: 0.4;"></div>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <div style="width: 18px; height: 18px; background: #10b981; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.55rem;">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <span style="font-size: 0.75rem; color: #059669; font-weight: 800; text-transform: uppercase;">Digitally Signed & Encrypted</span>
                                </div>
                            </div>
                            
                            <!-- REALISTIC SIGNATURE -->
                            <div style="font-family: 'Alex Brush', cursive; font-size: 2.8rem; color: #1e3a8a; margin-bottom: -15px; position: relative; z-index: 3; opacity: 0.9;">M. S. Patil</div>
                            
                            <div style="font-family: 'Cinzel', serif; font-weight: 900; font-size: 1.7rem; color: #1e3a8a; letter-spacing: 1px;">Authorized Signatory</div>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif($isBirth): ?>
            <!-- BIRTH CERTIFICATE FORMAT - STYLED SAME AS INCOME -->
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="font-size: 2.4rem; font-weight: 900; color: #166534; margin: 0; text-transform: uppercase;">
                    <?= $currentLang == 'hi' ? 'जन्म प्रमाण-पत्र' : 'BIRTH CERTIFICATE' ?>
                </h1>
                <div style="font-size: 0.9rem; font-weight: 800; color: #666; margin-top: 5px;">(Issued under Section 12/17 of the Births and Deaths Act, 1969)</div>
            </div>

            <!-- Meta Info Bar -->
            <div style="background: #f0fdf4; border-left: 6px solid #166534; padding: 15px 25px; border-radius: 4px 12px 12px 4px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
                <div style="font-weight: 800; font-size: 1.1rem; color: #1e293b;">
                    <?= $currentLang == 'hi' ? 'पंजीकरण क्र.' : 'Registration No' ?>: <span style="color: #166534;"><?= esc($record['registration_no']) ?></span>
                </div>
                <div style="font-weight: 800; font-size: 1.1rem; color: #1e293b;">
                    <?= $currentLang == 'hi' ? 'पंजीकरण दिनांक' : 'Registration Date' ?>: <span style="color: #166534;"><?= date('d/m/Y', strtotime($record['created_at'])) ?></span>
                </div>
            </div>

            <div class="cert-body">
                <p style="margin-bottom: 40px; line-height: 2.1; font-size: 1.2rem; color: #334155;">
                    <?php if($currentLang == 'hi'): ?>
                    यह प्रमाणित किया जाता है कि निम्नलिखित सूचना जन्म के मूल अभिलेख से ली गई है जो कि ग्राम पंचायत <b>बोदरली</b>, तहसील बुरहानपुर के रजिस्टर में अंकित है।
                    <?php else: ?>
                    This is to certify that the following information has been taken from the original record of birth for Gram Panchayat <b>Bodarli</b>, Tahsil Burhanpur (M.P.).
                    <?php endif; ?>
                </p>

                <div class="details-box" style="border: 2px solid #166534; padding: 0; overflow: hidden;">
                    <div style="padding: 20px 40px;">
                        <div class="detail-row" style="border-bottom: 1px solid #f1f5f9; padding: 15px 0;">
                            <div class="detail-label"><?= $currentLang == 'hi' ? 'बालक/बालिका का पूर्ण नाम' : 'Full Name of the Child' ?></div>
                            <div class="detail-colon">:</div>
                            <div class="detail-value" style="color: #166534; font-size: 1.6rem;"><b><?= esc($record['person_name']) ?></b></div>
                        </div>
                        <div class="detail-row" style="border-bottom: 1px solid #f1f5f9; padding: 15px 0;">
                            <div class="detail-label"><?= $currentLang == 'hi' ? 'लिंग' : 'Gender' ?></div>
                            <div class="detail-colon">:</div>
                            <div class="detail-value"><?= esc($record['gender']) ?></div>
                        </div>
                        <div class="detail-row" style="border-bottom: 1px solid #f1f5f9; padding: 15px 0;">
                            <div class="detail-label"><?= $currentLang == 'hi' ? 'जन्म की तारीख' : 'Date of Birth' ?></div>
                            <div class="detail-colon">:</div>
                            <div class="detail-value"><?= date('d/m/Y', strtotime($record['date_of_event'])) ?></div>
                        </div>
                        <div class="detail-row" style="border-bottom: 1px solid #f1f5f9; padding: 15px 0;">
                            <div class="detail-label"><?= $currentLang == 'hi' ? 'जन्म का स्थान' : 'Place of Birth' ?></div>
                            <div class="detail-colon">:</div>
                            <div class="detail-value"><?= esc($record['place_of_event']) ?></div>
                        </div>
                        <div class="detail-row" style="padding: 15px 0;">
                             <div class="detail-label"><?= $currentLang == 'hi' ? 'माता एवं पिता का नाम' : 'Parents Name' ?></div>
                             <div class="detail-colon">:</div>
                             <div class="detail-value"><b><?= esc($record['father_mother_name']) ?></b></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cert-footer" style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 100px; position: relative; z-index: 2;">
                <div style="text-align: center;">
                    <div id="qr-verify-birth-<?= $record['id'] ?>-<?= $currentLang ?>" style="padding: 8px; background: white; border: 2px solid #166534; border-radius: 8px; margin-bottom: 8px; display: inline-block;"></div>
                    <div style="font-size: 0.75rem; color: #166534; font-weight: 800;">VERIFY RECORD</div>
                    <script>
                        window.addEventListener('load', function() {
                            new QRCode(document.getElementById("qr-verify-birth-<?= $record['id'] ?>-<?= $currentLang ?>"), {
                                text: "<?= base_url('verify-id/' . $record['registration_no']) ?>",
                                width: 100,
                                height: 100,
                                colorDark : "#166534",
                                colorLight : "#ffffff",
                                correctLevel : QRCode.CorrectLevel.M
                            });
                        });
                    </script>
                </div>
                
                <div style="position: relative; width: 380px; text-align: center;">
                    <!-- OFFICIAL WET STAMP EFFECT -->
                    <div style="position: absolute; top: -85px; left: 50%; transform: translateX(-50%) rotate(-12deg); width: 160px; height: 160px; border: 4px double rgba(22, 101, 52, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; text-align: center; color: rgba(22, 101, 52, 0.3); font-size: 0.85rem; font-weight: 900; line-height: 1.3; pointer-events: none; z-index: 0;">
                        ग्राम पंचायत<br><b>बोदरली</b><br>(म.प्र.)
                    </div>
                    
                    <div style="border-top: 2.5px solid #166534; padding-top: 15px; position: relative; z-index: 2;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 8px;">
                            <div style="font-size: 1rem; font-weight: 800; color: #166534; font-family: 'Noto Sans Devanagari', sans-serif;">Registrar (Births & Deaths), Bodarli</div>
                            <div style="width: 1.5px; height: 20px; background: #166534; opacity: 0.4;"></div>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <div style="width: 18px; height: 18px; background: #10b981; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.55rem;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span style="font-size: 0.75rem; color: #059669; font-weight: 800; text-transform: uppercase;">Digitally Signed</span>
                            </div>
                        </div>
                        
                        <!-- REALISTIC SIGNATURE -->
                        <div style="font-family: 'Alex Brush', cursive; font-size: 2.8rem; color: #166534; margin-bottom: -15px; position: relative; z-index: 3; opacity: 0.9;">M. S. Patil</div>
                        
                        <div style="font-family: 'Cinzel', serif; font-weight: 900; font-size: 1.7rem; color: #166534; letter-spacing: 1px;">Authorized Signatory</div>
                    </div>
                </div>
            </div>

        <?php elseif($isDeath): ?>
            <!-- DEATH CERTIFICATE FORMAT - STYLED SAME AS INCOME -->
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="font-size: 2.4rem; font-weight: 900; color: #1e293b; margin: 0; text-transform: uppercase;">
                    <?= $currentLang == 'hi' ? 'मृत्यु प्रमाण-पत्र' : 'DEATH CERTIFICATE' ?>
                </h1>
                <div style="font-size: 0.9rem; font-weight: 800; color: #666; margin-top: 5px;">(Issued under Section 12/17 of the Births and Deaths Act, 1969)</div>
            </div>

            <!-- Meta Info Bar -->
            <div style="background: #f8fafc; border-left: 6px solid #1e293b; padding: 15px 25px; border-radius: 4px 12px 12px 4px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
                <div style="font-weight: 800; font-size: 1.1rem; color: #1e293b;">
                    <?= $currentLang == 'hi' ? 'पंजीकरण क्र.' : 'Registration No' ?>: <span style="color: #1e293b;"><?= esc($record['registration_no']) ?></span>
                </div>
                <div style="font-weight: 800; font-size: 1.1rem; color: #1e293b;">
                    <?= $currentLang == 'hi' ? 'पंजीकरण दिनांक' : 'Registration Date' ?>: <span style="color: #1e293b;"><?= date('d/m/Y', strtotime($record['created_at'])) ?></span>
                </div>
            </div>

            <div class="cert-body">
                <p style="margin-bottom: 40px; line-height: 2.1; font-size: 1.2rem; color: #334155;">
                    <?php if($currentLang == 'hi'): ?>
                    प्रमाणित किया जाता है कि निम्नलिखित सूचना मृत्यु के मूल अभिलेख से ली गई है जो कि ग्राम पंचायत <b>बोदरली</b> के रजिस्टर में अंकित है।
                    <?php else: ?>
                    This is to certify that the following information has been taken from the original death record for Gram Panchayat <b>Bodarli</b> (M.P.).
                    <?php endif; ?>
                </p>

                <div class="details-box" style="border: 2px solid #1e293b; padding: 0; overflow: hidden;">
                    <div style="padding: 20px 40px;">
                        <div class="detail-row" style="border-bottom: 1px solid #f1f5f9; padding: 15px 0;">
                            <div class="detail-label"><?= $currentLang == 'hi' ? 'मृतक का पूर्ण नाम' : 'Full Name of Deceased' ?></div>
                            <div class="detail-colon">:</div>
                            <div class="detail-value" style="color: #1e293b; font-size: 1.6rem;"><b><?= esc($record['person_name']) ?></b></div>
                        </div>
                        <div class="detail-row" style="border-bottom: 1px solid #f1f5f9; padding: 15px 0;">
                            <div class="detail-label"><?= $currentLang == 'hi' ? 'लिंग एवं आयु' : 'Gender & Age' ?></div>
                            <div class="detail-colon">:</div>
                            <div class="detail-value"><?= esc($record['gender']) ?> / <?= $record['age_at_event'] ?> Yrs</div>
                        </div>
                        <div class="detail-row" style="border-bottom: 1px solid #f1f5f9; padding: 15px 0;">
                            <div class="detail-label"><?= $currentLang == 'hi' ? 'मृत्यु की तारीख' : 'Date of Death' ?></div>
                            <div class="detail-colon">:</div>
                            <div class="detail-value"><?= date('d/m/Y', strtotime($record['date_of_event'])) ?></div>
                        </div>
                        <div class="detail-row" style="border-bottom: 1px solid #f1f5f9; padding: 15px 0;">
                            <div class="detail-label"><?= $currentLang == 'hi' ? 'मृत्यु का स्थान' : 'Place of Death' ?></div>
                            <div class="detail-colon">:</div>
                            <div class="detail-value"><?= esc($record['place_of_event']) ?></div>
                        </div>
                        <div class="detail-row" style="padding: 15px 0;">
                             <div class="detail-label"><?= $currentLang == 'hi' ? 'निकटतम संबंधी' : 'Relative Name' ?></div>
                             <div class="detail-colon">:</div>
                             <div class="detail-value"><b><?= esc($record['father_mother_name']) ?></b></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cert-footer" style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 100px; position: relative; z-index: 2;">
                <div style="text-align: center;">
                    <div id="qr-verify-death-<?= $record['id'] ?>-<?= $currentLang ?>" style="padding: 8px; background: white; border: 2px solid #1e293b; border-radius: 8px; margin-bottom: 8px; display: inline-block;"></div>
                    <div style="font-size: 0.75rem; color: #1e293b; font-weight: 800;">VERIFY RECORD</div>
                    <script>
                        window.addEventListener('load', function() {
                            new QRCode(document.getElementById("qr-verify-death-<?= $record['id'] ?>-<?= $currentLang ?>"), {
                                text: "<?= base_url('verify-id/' . $record['registration_no']) ?>",
                                width: 100,
                                height: 100,
                                colorDark : "#1e293b",
                                colorLight : "#ffffff",
                                correctLevel : QRCode.CorrectLevel.M
                            });
                        });
                    </script>
                </div>
                
                <div style="position: relative; width: 380px; text-align: center;">
                    <!-- OFFICIAL WET STAMP EFFECT -->
                    <div style="position: absolute; top: -85px; left: 50%; transform: translateX(-50%) rotate(-12deg); width: 160px; height: 160px; border: 4px double rgba(30, 41, 59, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; text-align: center; color: rgba(30, 41, 59, 0.3); font-size: 0.85rem; font-weight: 900; line-height: 1.3; pointer-events: none; z-index: 0;">
                        ग्राम पंचायत<br><b>बोदरली</b><br>(म.प्र.)
                    </div>
                    
                    <div style="border-top: 2.5px solid #1e293b; padding-top: 15px; position: relative; z-index: 2;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 8px;">
                            <div style="font-size: 1rem; font-weight: 800; color: #1e293b; font-family: 'Noto Sans Devanagari', sans-serif;">Registrar (Births & Deaths), Bodarli</div>
                            <div style="width: 1.5px; height: 20px; background: #1e293b; opacity: 0.4;"></div>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <div style="width: 18px; height: 18px; background: #10b981; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.55rem;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span style="font-size: 0.75rem; color: #059669; font-weight: 800; text-transform: uppercase;">Digitally Signed</span>
                            </div>
                        </div>
                        
                        <!-- REALISTIC SIGNATURE -->
                        <div style="font-family: 'Alex Brush', cursive; font-size: 2.8rem; color: #1e293b; margin-bottom: -15px; position: relative; z-index: 3; opacity: 0.9;">M. S. Patil</div>

                        <div style="font-family: 'Cinzel', serif; font-weight: 900; font-size: 1.7rem; color: #1e293b; letter-spacing: 1px;">Authorized Signatory</div>
                    </div>
                </div>
            </div>
        <?php elseif($isCaste): ?>
            <!-- CASTE CERTIFICATE FORMAT -->
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="font-size: 2.6rem; font-weight: 900; color: #c2410c; margin: 0; text-transform: uppercase; font-family: 'Noto Sans Devanagari', sans-serif;">
                    <?= $currentLang == 'hi' ? 'जाति प्रमाण-पत्र' : 'CASTE CERTIFICATE' ?>
                </h1>
                <div style="font-size: 1rem; font-weight: 800; color: #c2410c; margin-top: 5px;">(मध्य प्रदेश शासन - राजस्व विभाग)</div>
            </div>

            <div style="border: 2px solid #ea580c; border-radius: 12px; padding: 25px; background: #fff7ed; margin-bottom: 30px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-size: 0.85rem; color: #9a3412; font-weight: 700;">REGISTRATION NO</div>
                        <div style="font-size: 1.25rem; font-weight: 900; color: #c2410c;"><?= esc($record['registration_no']) ?></div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 0.85rem; color: #9a3412; font-weight: 700;">CATEGORY</div>
                        <div style="font-size: 1.25rem; font-weight: 900; color: #c2410c;"><?= esc($record['category']) ?></div>
                    </div>
                </div>
            </div>

            <div class="cert-body">
                <p style="text-indent: 50px; line-height: 2.2; font-size: 1.2rem; color: #1f2937; text-align: justify; margin-bottom: 30px;">
                    <?php if($currentLang == 'hi'): ?>
                    प्रमाणित किया जाता है कि श्री/श्रीमती <b><?= esc($record['person_name']) ?></b> पुत्र/पुत्री श्री <b><?= esc($record['father_mother_name']) ?></b>, ग्राम <b>बोदरली</b> के निवासी हैं। आपकी जाति <b><?= esc($record['caste_name']) ?></b> है, जो मध्य प्रदेश शासन द्वारा <b><?= esc($record['category']) ?></b> श्रेणी के अंतर्गत अधिसूचित है। यह प्रमाण-पत्र आपके द्वारा प्रस्तुत दस्तावेजों एवं स्थानीय सत्यापन के आधार पर जारी किया गया है।
                    <?php else: ?>
                    This is to certify that Mr./Ms. <b><?= esc($record['person_name']) ?></b> S/o D/o Mr. <b><?= esc($record['father_mother_name']) ?></b>, Resident of Village <b>Bodarli</b>, is a permanent resident. Your Caste is <b><?= esc($record['caste_name']) ?></b>, which is notified under the <b><?= esc($record['category']) ?></b> category by the Government of Madhya Pradesh.
                    <?php endif; ?>
                </p>

                <div class="details-box" style="border-color: #ea580c; border-width: 2px;">
                    <div class="detail-row">
                        <div class="detail-label" style="color: #9a3412;">Religion / धर्म</div>
                        <div class="detail-colon">:</div>
                        <div class="detail-value"><?= esc($record['religion'] ?? 'Hindu') ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label" style="color: #9a3412;">Main Caste / जाति</div>
                        <div class="detail-colon">:</div>
                        <div class="detail-value"><?= esc($record['caste_name']) ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label" style="color: #9a3412;">Sub-Caste / उप-जाति</div>
                        <div class="detail-colon">:</div>
                        <div class="detail-value"><?= esc($record['sub_caste'] ?? 'N/A') ?></div>
                    </div>
                </div>
            </div>

            <div class="cert-footer" style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 100px; position: relative; z-index: 2;">
                <div style="text-align: center;">
                    <div id="qr-verify-caste-<?= $record['id'] ?>-<?= $currentLang ?>" style="padding: 8px; background: white; border: 2px solid #ea580c; border-radius: 8px; margin-bottom: 8px; display: inline-block;"></div>
                    <div style="font-size: 0.75rem; color: #ea580c; font-weight: 800;">VERIFY CASTE</div>
                    <script>
                        window.addEventListener('load', function() {
                            new QRCode(document.getElementById("qr-verify-caste-<?= $record['id'] ?>-<?= $currentLang ?>"), {
                                text: "<?= base_url('verify-id/' . $record['registration_no']) ?>",
                                width: 100,
                                height: 100,
                                colorDark : "#ea580c",
                                colorLight : "#ffffff",
                                correctLevel : QRCode.CorrectLevel.M
                            });
                        });
                    </script>
                </div>
                
                <div style="position: relative; width: 380px; text-align: center;">
                    <!-- OFFICIAL WET STAMP EFFECT (MOVED HIGHER) -->
                    <div style="position: absolute; top: -85px; left: 50%; transform: translateX(-50%) rotate(-12deg); width: 160px; height: 160px; border: 4px double rgba(234, 88, 12, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; text-align: center; color: rgba(234, 88, 12, 0.3); font-size: 0.85rem; font-weight: 900; line-height: 1.3; pointer-events: none; z-index: 0;">
                        राजस्व विभाग<br><b>ग्राम पंचायत बोदरली</b><br>मध्यप्रदेश शासन
                    </div>
                    
                    <div style="border-top: 2.5px solid #ea580c; padding-top: 15px; position: relative; z-index: 2;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 8px;">
                            <div style="font-size: 1.1rem; font-weight: 800; color: #9a3412; font-family: 'Noto Sans Devanagari', sans-serif;">सचिव, ग्राम पंचायत बोदरली (बुरहानपुर)</div>
                            <div style="width: 1.5px; height: 20px; background: #ea580c; opacity: 0.4;"></div>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <div style="width: 18px; height: 18px; background: #10b981; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.55rem;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span style="font-size: 0.75rem; color: #059669; font-weight: 800; text-transform: uppercase;">Digitally Signed & Encrypted</span>
                            </div>
                        </div>
                                                <!-- REALISTIC SIGNATURE -->
                            <div style="font-family: 'Alex Brush', cursive; font-size: 2.8rem; color: #c2410c; margin-bottom: -15px; position: relative; z-index: 3; opacity: 0.9;">M. S. Patil</div>
                            
                            <div style="font-family: 'Cinzel', serif; font-weight: 900; font-size: 1.7rem; color: #c2410c; letter-spacing: 1px;">Authorized Signatory</div>
                    </div>
                </div>
            </div>

        <?php elseif($isDomicile): ?>
            <!-- DOMICILE CERTIFICATE FORMAT -->
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="font-size: 2.6rem; font-weight: 900; color: #1e3a8a; margin: 0; text-transform: uppercase;">
                    <?= $currentLang == 'hi' ? 'मूल निवास प्रमाण-पत्र' : 'DOMICILE CERTIFICATE' ?>
                </h1>
                <div style="font-size: 1rem; font-weight: 800; color: #1e3a8a; margin-top: 5px;">(Certificate of Permanent Residence)</div>
            </div>

            <div style="background: #eff6ff; border-left: 8px solid #1e3a8a; padding: 20px 35px; border-radius: 4px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
                <div style="font-weight: 900; font-size: 1.2rem; color: #1e3a8a;">Reg No: <?= esc($record['registration_no']) ?></div>
                <div style="font-weight: 900; font-size: 1.2rem; color: #1e3a8a;">Date: <?= date('d/m/Y', strtotime($record['created_at'])) ?></div>
            </div>

            <div class="cert-body">
                <p style="text-indent: 50px; line-height: 2.3; font-size: 1.25rem; color: #0f172a; text-align: justify; margin-bottom: 40px;">
                    <?php if($currentLang == 'hi'): ?>
                    प्रमाणित किया जाता है कि श्री/श्रीमती <b><?= esc($record['person_name']) ?></b> पुत्र/पुत्री श्री <b><?= esc($record['father_mother_name']) ?></b>, पिछले <b><?= esc($record['stay_duration'] ?? '15+') ?> वर्षों</b> से अधिक समय से ग्राम <b>बोदरली</b>, जिला बुरहानपुर के स्थायी निवासी हैं। यह प्रमाण-पत्र आपकी पहचान संख्या <b><?= esc($record['id_proof_no'] ?? 'Aadhar Verified') ?></b> के आधार पर जारी किया गया है।
                    <?php else: ?>
                    This is to verify that Mr./Ms. <b><?= esc($record['person_name']) ?></b> S/o D/o Mr. <b><?= esc($record['father_mother_name']) ?></b>, has been a permanent resident of Village <b>Bodarli</b>, District Burhanpur, for the last <b><?= esc($record['stay_duration'] ?? '15+') ?> years</b>. This certificate is issued based on ID proof <b><?= esc($record['id_proof_no'] ?? 'N/A') ?></b>.
                    <?php endif; ?>
                </p>

                <div class="details-box" style="border: 2px solid #1e3a8a; padding: 0; overflow: hidden; background: #fff;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 1.15rem;">
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 15px 30px; font-weight: 700; color: #475569; width: 300px;"><?= $currentLang == 'hi' ? 'निवास पता' : 'Residential Address' ?></td>
                            <td style="padding: 15px 30px; font-weight: 900; color: #1e3a8a;">Village: Bodarli, Burhanpur (M.P.)</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 15px 30px; font-weight: 700; color: #475569;"><?= $currentLang == 'hi' ? 'वार्ड क्रमांक' : 'Ward Number' ?></td>
                            <td style="padding: 15px 30px; font-weight: 800; color: #334155;"><?= esc($record['village_ward'] ?? '07') ?></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 15px 30px; font-weight: 700; color: #475569;"><?= $currentLang == 'hi' ? 'निवास अवधि' : 'Stay Duration' ?></td>
                            <td style="padding: 15px 30px; font-weight: 800; color: #334155;"><?= esc($record['stay_duration'] ?? '15+') ?> Years</td>
                        </tr>
                        <tr>
                            <td style="padding: 15px 30px; font-weight: 700; color: #475569;"><?= $currentLang == 'hi' ? 'पहचान संख्या' : 'Identity Verification' ?></td>
                            <td style="padding: 15px 30px; font-weight: 800; color: #334155; font-family: monospace;"><?= esc($record['id_proof_no'] ?? 'VERIFIED_BY_AADHAR') ?></td>
                        </tr>
                    </table>
                </div>
            </div>

                <div class="cert-footer" style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 100px; position: relative; z-index: 2;">
                    <div style="text-align: center;">
                        <div id="qr-verify-<?= $record['id'] ?>-<?= $currentLang ?>" style="padding: 8px; background: white; border: 2px solid #1e3a8a; border-radius: 8px; margin-bottom: 8px; display: inline-block;"></div>
                        <div style="font-size: 0.75rem; color: #1e3a8a; font-weight: 800;">VERIFY DOCUMENT</div>
                        <script>
                            window.addEventListener('load', function() {
                                new QRCode(document.getElementById("qr-verify-<?= $record['id'] ?>-<?= $currentLang ?>"), {
                                    text: "<?= base_url('verify-id/' . $record['registration_no']) ?>",
                                    width: 100,
                                    height: 100,
                                    colorDark : "#1e3a8a",
                                    colorLight : "#ffffff",
                                    correctLevel : QRCode.CorrectLevel.M
                                });
                            });
                        </script>
                    </div>
                    
                    <div style="position: relative; width: 380px; text-align: center;">
                    <!-- OFFICIAL WET STAMP EFFECT -->
                    <div style="position: absolute; top: -85px; left: 50%; transform: translateX(-50%) rotate(-12deg); width: 165px; height: 165px; border: 4px double rgba(30, 58, 138, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; text-align: center; color: rgba(30, 58, 138, 0.3); font-size: 0.85rem; font-weight: 900; line-height: 1.3; pointer-events: none; z-index: 0;">
                        निवास पंजीयन<br><b>ग्राम पंचायत बोदरली</b><br>मध्यप्रदेश शासन
                    </div>
                    
                    <div style="border-top: 2.5px solid #1e3a8a; padding-top: 15px; position: relative; z-index: 2;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 8px;">
                            <div style="font-size: 1rem; font-weight: 800; color: #1e3a8a; font-family: 'Noto Sans Devanagari', sans-serif;">सचिव, ग्राम पंचायत बोदरली (बुरहानपुर)</div>
                            <div style="width: 1.5px; height: 20px; background: #1e3a8a; opacity: 0.4;"></div>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <div style="width: 18px; height: 18px; background: #10b981; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.55rem;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span style="font-size: 0.75rem; color: #059669; font-weight: 800; text-transform: uppercase;">Digitally Signed</span>
                            </div>
                        </div>
                        
                        <div style="font-family: 'Cinzel', serif; font-weight: 900; font-size: 1.7rem; color: #1e3a8a; letter-spacing: 1px;">Authorized Signatory</div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
        <?php endforeach; ?>
</body>
</html>
