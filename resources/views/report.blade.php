<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Medical report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .flex {
            display: flex;
            align-items: flex-end;
        }

        .flex-2 {
            display: flex;
        }

        .form-control {
            border-width: 0 0 1px 0;
            border-radius: 0;
            padding: 0;
            border-color: #000000;
            border-style: dotted;
        }

        .form-label {
            margin-bottom: 0;
            line-height: 1.1;
        }

        tbody tr {
            border-width: 0 0 !important;
        }

        tbody tr:last-child {
            border-width: 0 0 1px !important;
        }

        .no-border tbody tr:last-child {
            border-width: 0 0 !important;
        }

        .custom-table .form-control {
            display: inline-block;
            width: 80%;
        }

        .form-wrapper {
            width: 100%;
            display: table;
        }

        .form-wrapper .form-label,
        .form-wrapper .form-control {
            display: table-cell;
        }

        .form-wrapper .form-label {
            width: 1%;
            white-space: nowrap;
            vertical-align: middle;
            padding-right: 15px;
        }

        .form-wrapper .form-control {
            width: 100%;
        }

        table.custom-table tr.cols td:first-child {
            padding-right: 10px;
        }

        table.custom-table tr.cols td:last-child {
            padding-left: 10px;
        }

        .table {
            border-left: 0.01em solid #000;
            border-right: 0;
            border-top: 0.01em solid #000;
            border-bottom: 0;
            border-collapse: collapse;
        }

        /*.table td,
        .table th {
            border-left: 0;
            border-right: 0.01em solid #000;
            border-top: 0;
            border-bottom: 0.01em solid #000;
        }*/

        .table th {
            border-left: 0;
            border-right: 0.01em solid #000;
            border-top: 0;
            border-bottom: 0.01em solid #000;
        }

        .table td {
            border-left: 0;
            border-right: 0.01em solid #000;
            border-top: 0;
            border-bottom: 0;
        }

        .table {
            border-color: #000000;
        }

        .table tr td,
        .table tr th {
            padding: 0 10px;
        }

        body,
        .form-control {
            font-size: 14px;
        }

        table.no-border,
        table.no-border td,
        table.no-border th {
            border-left: 0;
            border-right: 0;
            border-top: 0;
            border-bottom: 0;
        }

        table.no-border tr td:first-child {
            padding-left: 0;
        }

        input[type='checkbox'] {
            vertical-align: middle;
        }

        /*.form-wrapper.fw .form-control {
            width: calc(99% - 12px);
        }*/
    </style>
</head>

<body>
    <div class="">
        <h5 class="text-center pt-3"><strong>METROCARE<br>
                MEDICAL EXAMINATION REPORT – STRICTLY CONFIDENTIAL<br>
                PRE EMPLOYMENT MEDICAL</strong></h5>
        <table class="no-border custom-table" width="100%" style="table-layout:fixed;">
            <tr class="cols">
                <td>
                    <div class="mb-3 form-wrapper">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" value="{{$patient->name}}">
                    </div>
                </td>
                <td>
                    <div class="mb-3 form-wrapper">
                        <label class="form-label">Sex</label>
                        <input type="text" class="form-control" value="{{$patient->sex_name}}">
                    </div>
                </td>
            </tr>
            <tr class="cols">
                <td>
                    <div class="mb-3 form-wrapper">
                        <label class="form-label">ID / Passport No. :</label>
                        <input type="text" class="form-control" value="{{$patient->id_no}}">
                    </div>
                </td>
                <td>
                    <div class="mb-3 form-wrapper">
                        <label class="form-label">D.O. B. (dd/mm/yr)</label>
                        <input type="text" class="form-control" value="{{$patient->dob}}">
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="mb-3 form-wrapper fw">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" value="{{$patient->email}}">
                    </div>
                </td>
            </tr>
            <tr class="cols">
                <td>
                    <div class="mb-3 form-wrapper">
                        <label class="form-label">Resident County.</label>
                        <input type="text" class="form-control" value="{{$patient->county_name}}">
                    </div>
                </td>
                <td>
                    <div class="mb-3 form-wrapper">
                        <label class="form-label">Cellphone</label>
                        <input type="text" class="form-control" value="{{$patient->phone}}">
                    </div>
                </td>
            </tr>
            <tr class="cols">
                <td>
                    <div class="mb-3 form-wrapper">
                        <label class="form-label">Personal Physician if any</label>
                        <input type="text" class="form-control" value="{{$patient->physician}}">
                    </div>
                </td>
                <td>
                    <div class="mb-3 form-wrapper">
                        <label class="form-label">Tel</label>
                        <input type="text" class="form-control" value="{{$patient->physician_tel}}">
                    </div>
                </td>
            </tr>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th>RESPIRATORY SYSTEM</th>
                    <th class="text-center" style="width:50px">YES</th>
                    <th class="text-center" style="width:50px">NO</th>
                    <th style="width:180px">COMMENTS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Previous history?</td>
                    <td class="text-center">
                        <input type="checkbox" {{  ($respiratory->history == 1 ? ' checked' : '') }}>
                    </td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($respiratory->history == 0 ? ' checked' : '') }}>
                    </td>
                    <td rowspan="9">{{$respiratory->comments}}</td>
                </tr>
                <tr>
                    <td>Pneumonia</td>
                    <td class="text-center">
                        <input type="checkbox" {{  ($respiratory->pneumonia == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">
                        <input type="checkbox" {{  ($respiratory->pneumonia == 0 ? ' checked' : '') }}>

                    </td>
                </tr>
                <tr>
                    <td>Bronchial asthma</td>
                    <td class="text-center">
                        <input type="checkbox" {{  ($respiratory->bronchial_asthma == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">
                        <input type="checkbox" {{  ($respiratory->bronchial_asthma == 0 ? ' checked' : '') }}>

                    </td>
                </tr>
                <tr>
                    <td>TB(unexplained persistent night sweat)</td>
                    <td class="text-center">
                        <input type="checkbox" value="" {{  ($respiratory->tb == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">
                        <input type="checkbox" {{  ($respiratory->tb == 0 ? ' checked' : '') }}>

                    </td>
                </tr>
                <tr>
                    <td>Are there signs of decreased chest expansion?</td>
                    <td class="text-center">
                        <input type="checkbox" {{  ($respiratory->chest_expansion == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">
                        <input type="checkbox" {{  ($respiratory->chest_expansion == 0 ? ' checked' : '') }}>

                    </td>
                </tr>
                <tr>
                    <td>Are there signs of abnormal dullness to percussion?</td>
                    <td class="text-center">
                        <input type="checkbox" {{  ($respiratory->abnormal_dullness == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">
                        <input type="checkbox" {{  ($respiratory->abnormal_dullness == 0 ? ' checked' : '') }}>

                    </td>
                </tr>
                <tr>
                    <td>Are there abnormal auscultatory signs?</td>
                    <td class="text-center">
                        <input type="checkbox" {{  ($respiratory->abnormal_auscultatory == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($respiratory->abnormal_auscultatory == 0 ? ' checked' : '') }}>

                    </td>
                </tr>
                <tr>
                    <td>Is the voice normal?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($respiratory->voice == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($respiratory->voice == 0 ? ' checked' : '') }}>

                    </td>
                </tr>
                <tr>
                    <td><b>NECK:</b> Is there evidence of goitre?</td>
                    <td class="text-center">
                        <input type="checkbox" {{  ($respiratory->goitre == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">
                        <input type="checkbox" {{  ($respiratory->goitre == 0 ? ' checked' : '') }}>

                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th>CARDIOVASCULAR SYSTEM</th>
                    <th class="text-center" style="width:50px">YES</th>
                    <th class="text-center" style="width:50px">NO</th>
                    <th style="width:180px">COMMENTS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>High Blood pressure</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($cardiovascular->blood_pressure == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($cardiovascular->blood_pressure == 0 ? ' checked' : '') }}>

                    </td>
                    <td>{{$cardiovascular->comments}}</td>
                </tr>
                <tr>
                    <td>Shortness of breath</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($cardiovascular->breath == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($cardiovascular->breath == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Palp Hatious</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($cardiovascular->palp == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($cardiovascular->palp == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Previous history</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($cardiovascular->history == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($cardiovascular->history == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Is the heart enlarged?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($cardiovascular->heart_enlarged == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($cardiovascular->heart_enlarged == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Are the heart sounds normal? (intensity, splitting, etc)</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($cardiovascular->heart_sounds == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($cardiovascular->heart_sounds == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Are there any cadiac murmurs?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($cardiovascular->cadiac_murmurs == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($cardiovascular->cadiac_murmurs == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Does the murmur seem to be pathological?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($cardiovascular->murmur_pathological == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($cardiovascular->murmur_pathological == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Does the murmur irradiate?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($cardiovascular->murmur_irradiate == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($cardiovascular->murmur_irradiate == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Where is the maximal intensity?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($cardiovascular->maximal_intensity == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($cardiovascular->maximal_intensity == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Does the abdominal aorta seem dilated?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($cardiovascular->abdominal_aorta_dilated == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($cardiovascular->abdominal_aorta_dilated == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Are the peripheral pulses all present and Symmetrical?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($cardiovascular->peripheral_pulses == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($cardiovascular->peripheral_pulses == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Are there any arterial bruits in the cervical And femoral regions?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($cardiovascular->arterial_bruits == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($cardiovascular->arterial_bruits == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th>GASTROINTENSTINAL SYSTEM</th>
                    <th class="text-center" style="width:50px">YES</th>
                    <th class="text-center" style="width:50px">NO</th>
                    <th style="width:180px">COMMENTS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Previous history?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($gastrointestinal->history == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($gastrointestinal->history == 0 ? ' checked' : '') }}>

                    </td>
                    <td>{{$gastrointestinal->comments}}</td>
                </tr>
                <tr>
                    <td>Are there any abnormalities of the mouth, Tongue, pharynx or tonsils?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($gastrointestinal->abnormalities_mouth == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($gastrointestinal->abnormalities_mouth == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Are there any abnormalities of the abdomen
                        on palpitation?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($gastrointestinal->abnormalities_abdomen == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($gastrointestinal->abnormalities_abdomen == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Hepatomegaly?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($gastrointestinal->hepatomegaly == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($gastrointestinal->hepatomegaly == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Splenomegaly?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($gastrointestinal->splenomegaly == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($gastrointestinal->splenomegaly == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Are there any abnormalities of the hernial
                        orifices?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($gastrointestinal->abnormalities_hernial_orifices == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($gastrointestinal->abnormalities_hernial_orifices == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Are there signs of haemorrhoids, previous
                        melaena or rectal bleeding?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($gastrointestinal->signs_haemorrhoids == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($gastrointestinal->signs_haemorrhoids == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th>GENITO URINARY SYSTEM</th>
                    <th class="text-center" style="width:50px">YES</th>
                    <th class="text-center" style="width:50px">NO</th>
                    <th style="width:180px">COMMENTS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Previous history?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($genito->history == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($genito->history == 0 ? ' checked' : '') }}>

                    </td>
                    <td>{{$genito->comments}}</td>
                </tr>
                <tr>
                    <td>Genital sores</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($genito->genital_sores == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($genito->genital_sores == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>For men:</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Are there any signs of disease of the genital
                        organs (testis, epididymes, prostate)?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($genito->genitals_male == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($genito->genitals_male == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Is there gynaecomastia?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($genito->gynaecomastia == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($genito->gynaecomastia == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>For women:</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Are there any signs of disease of the genital
                        organs?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($genito->genitals_female == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($genito->genitals_female == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Are there any abnormalities of the breast?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($genito->breast == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($genito->breast == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Last normal menstrual period?
                    </td>
                    <td class="text-center">{{ $genito->menstrual }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th>CENTRAL NERVOUS SYSTEM</th>
                    <th class="text-center" style="width:50px">YES</th>
                    <th class="text-center" style="width:50px">NO</th>
                    <th style="width:180px">COMMENTS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Previous history?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($central->history == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($central->history == 0 ? ' checked' : '') }}>

                    </td>
                    <td>{{$central->comments}}</td>
                </tr>
                <tr>
                    <td>Sequellae:</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($central->sequellae == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($central->sequellae == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Are the papillary, abdominal or tendon
                        reflexes abnormal?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($central->papillary == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($central->papillary == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Are there any signs of autonomic nervous
                        dysfunction?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($central->nervous_dysfunction == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($central->nervous_dysfunction == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Are there any psychiatric or neurological
                        abnormalities?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($central->neurological_abnormalities == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($central->neurological_abnormalities == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Any mental health issues</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($central->mental_health == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($central->mental_health == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Severe headaches</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($central->headaches == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($central->headaches == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th>SKIN AND TEGUMENTS</th>
                    <th class="text-center" style="width:50px">YES</th>
                    <th class="text-center" style="width:50px">NO</th>
                    <th style="width:180px">COMMENTS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Are there any signs of:</td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>{{$skin->comments}}</td>
                </tr>
                <tr>
                    <td>Jaundice or cyanosis?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($skin->jaundice_cyanosis == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($skin->jaundice_cyanosis == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Skin eruption, cyst, tumour, varicosities or
                        Oedema?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($skin->skin_eruption == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($skin->skin_eruption == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Lymphadenopathy?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($skin->lymphadenopathy == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($skin->lymphadenopathy == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Scars or tattoos?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($skin->scars_tattoos == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($skin->scars_tattoos == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Tophi and xanthomata?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($skin->xanthomata == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($skin->xanthomata == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th>SKELETAL SYSTEM</th>
                    <th class="text-center" style="width:50px">YES</th>
                    <th class="text-center" style="width:50px">NO</th>
                    <th style="width:180px">COMMENTS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Are there any abnormalities of the bones,
                        joints, or intervertebral discs?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($skeletal->bones_joints == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($skeletal->bones_joints == 0 ? ' checked' : '') }}>

                    </td>
                    <td>{{$skeletal->comments}}</td>
                </tr>
                <tr>
                    <td>Rheumatism</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($skeletal->rheumatism == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($skeletal->rheumatism == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th>SENSORY ORGANS</th>
                    <th class="text-center" style="width:50px">YES</th>
                    <th class="text-center" style="width:50px">NO</th>
                    <th style="width:180px">COMMENTS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Is there any disease of the eyes?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($sensory->eyes == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($sensory->eyes == 0 ? ' checked' : '') }}>

                    </td>
                    <td>{{$sensory->comments}}</td>
                </tr>
                <tr>
                    <td>Visual acuity? R L</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($sensory->visual_acuity == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($sensory->visual_acuity == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Before correction /6 /6</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($sensory->b_correction == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($sensory->b_correction == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>After correction /6 /6</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($sensory->a_correction == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($sensory->a_correction == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Is there any disease of the ears?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($sensory->ears == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($sensory->ears == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th>PAST MEDICAL HISTORY</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="mb-3 form-wrapper">
                            <label class="form-label">Prior hospital admission</label>
                            <input type="text" class="form-control" value="{{$medical->admission}}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="no-border" style="width:100%">
                            <tr>
                                <td><b>Any chronic illness-</b></td>
                                <td><label class="form-check-label" for="flexCheckDefault">
                                        Diabetes
                                    </label>
                                    <input type="checkbox" {{  (in_array(1, $medical->chronic_illness) ? ' checked' : '') }}>
                                </td>
                                <td>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Hypertension
                                    </label>
                                    <input type="checkbox" {{  (in_array(2, $medical->chronic_illness) ? ' checked' : '') }}>

                                </td>
                                <td>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Asthma
                                    </label>
                                    <input type="checkbox" {{  (in_array(3, $medical->chronic_illness) ? ' checked' : '') }}>

                                </td>
                                <td>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Cancer
                                    </label>
                                    <input type="checkbox" {{  (in_array(4, $medical->chronic_illness) ? ' checked' : '') }}>

                                </td>
                                <td>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        HIV
                                    </label>
                                    <input type="checkbox" {{  (in_array(5, $medical->chronic_illness) ? ' checked' : '') }}>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="no-border mb-1">
                            <tr>
                                <td><b>Is the examinee currently under medical treatment</b></td>
                                <td><label class="form-check-label" for="flexCheckDefault">
                                        Yes
                                    </label>
                                    <input type="checkbox" {{  ($medical->medical_treatment == 1 ? ' checked' : '') }}>
                                </td>
                                <td><label class="form-check-label" for="flexCheckDefault">
                                        No
                                    </label>
                                    <input type="checkbox" {{  ($medical->medical_treatment == 1 ? ' checked' : '') }}>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="no-border" width="100%">
                            <tr>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">If yes specify</label>
                                        <input type="text" class="form-control" value="{{$medical->medical_treatment_which}}">
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Since when</label>
                                        <input type="text" class="form-control" value="{{$medical->medical_treatment_when}}">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="no-border mb-1">
                            <tr>
                                <td><b>Have you ever received blood transfusion?</b></td>
                                <td><label class="form-check-label" for="flexCheckDefault">
                                        Yes
                                    </label>
                                    <input type="checkbox" {{  ($medical->blood_transfusion == 1 ? ' checked' : '') }}>
                                </td>
                                <td><label class="form-check-label" for="flexCheckDefault">
                                        No
                                    </label>
                                    <input type="checkbox" {{  ($medical->blood_transfusion == 1 ? ' checked' : '') }}>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th>SOCIAL HISTORY</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="mb-3">
                            <div class="form-wrapper">
                                <label class="form-label">Marital status</label>
                                <input type="text" class="form-control" value="{{$social->marital_status}}">
                            </div>
                            <p>(Where applicable, cause of death of spouse)</p>
                        </div>
                        <table class="no-border" width="100%">
                            <tr>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Number of children</label>
                                        <input type="text" class="form-control" value="{{$social->no_children}}">
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Profession</label>
                                        <input type="text" class="form-control" value="{{$social->profession}}">
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <p><b>(i) HABITS</b></p>
                        <div class="mb-3 form-wrapper">
                            <label class="form-label">Units of alcohol/sitting</label>
                            <input type="text" class="form-control" value="{{$social->units_alcohol}}">
                        </div>
                        <table class="no-border" width="100%">
                            <tr>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">No. of cigarettes/day</label>
                                        <input type="text" class="form-control" value="{{$social->no_cigarettes}}">
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Duration of smoking</label>
                                        <input type="text" class="form-control" value="{{$social->duration_smoking}}">
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <p>(ii) If female:-</p>
                        <div class="mb-3 form-wrapper">
                            <label class="form-label">a) Menstrual cycle – duration, flow, abnormality</label>
                            <input type="text" class="form-control" value="{{$social->menstrual_cycle}}">
                        </div>
                        <div class="mb-3 form-wrapper">
                            <label class="form-label">b) Contraception history</label>
                            <input type="text" class="form-control" value="{{$social->contraception}}">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th>FAMILY HISTORY OF ANY OF THE FOLLOWING DISEASES</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <table class="no-border" style="width:100%">
                            <tr>
                                <td>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Ischemic heart disease
                                    </label>
                                    <input type="checkbox" {{  (in_array(1, $family->history) ? ' checked' : '') }}>
                                </td>
                                <td>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Hypertension
                                    </label>
                                    <input type="checkbox" {{  (in_array(2, $family->history) ? ' checked' : '') }}>
                                </td>
                                <td>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Bronchial asthma
                                    </label>
                                    <input type="checkbox" {{  (in_array(3, $family->history) ? ' checked' : '') }}>
                                </td>
                                <td>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Allergic skin conditions
                                    </label>
                                    <input type="checkbox" {{  (in_array(4, $family->history) ? ' checked' : '') }}>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Diabetes
                                    </label>
                                    <input type="checkbox" {{  (in_array(5, $family->history) ? ' checked' : '') }}>
                                </td>
                                <td>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Mental disorder
                                    </label>
                                    <input type="checkbox" {{  (in_array(6, $family->history) ? ' checked' : '') }}>
                                </td>
                                <td>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Sudden death
                                    </label>
                                    <input type="checkbox" {{  (in_array(7, $family->history) ? ' checked' : '') }}>
                                </td>
                                <td>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Cancer
                                    </label>
                                    <input type="checkbox" {{  (in_array(8, $family->history) ? ' checked' : '') }}>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th colspan="4">GENERAL APPEARANCE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4">
                        <table class="no-border" width="100%">
                            <tr>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Height:</label>
                                        <input type="text" class="form-control" value="{{$appearance->height}}">
                                        <span>cm</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Waist measurement:</label>
                                        <input type="text" class="form-control" value="{{$appearance->waist}}">
                                        <span>cm</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table class="no-border" width="100%">
                            <tr>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Weight:</label>
                                        <input type="text" class="form-control" value="{{$appearance->weight}}">
                                        <span>kg</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Hip measurement:</label>
                                        <input type="text" class="form-control" value="{{$appearance->hip}}">
                                        <span>cm</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">BMI:</label>
                                        <input type="text" class="form-control" value="{{$appearance->bmi}}">
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="mb-3 form-wrapper">
                            <label class="form-label"> - Healthy, looks declared age?</label>
                            <input type="text" class="form-control" value="{{$appearance->age}}">
                        </div>
                        <div class="mb-3 form-wrapper">
                            <label class="form-label"> - Morphological type?</label>
                            <input type="text" class="form-control" value="{{$appearance->morphological}}">
                        </div>
                    </td>
                </tr>
            </tbody>
            <thead>
                <th></th>
                <th class="text-center" width="50">YES</th>
                <th class="text-center" width="50">NO</th>
                <th width="180">COMMENTS</th>
            </thead>
            <tbody>
                <tr>
                    <td>Are there any malformations or mutations?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($appearance->mutations == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($appearance->mutations == 0 ? ' checked' : '') }}>

                    </td>
                    <td>{{$appearance->comments}}</td>
                </tr>
                <tr>
                    <td>Are there any stigmata of alcohol, tobacco, or drug abuse?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($appearance->stigmata == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($appearance->stigmata == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Are there any repercussions of the proper’s
                        professional or social activities on the general
                        state of health?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($appearance->state_health == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($appearance->state_health == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th>BLOOD PRESSURE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <table class="no-border" width="100%">
                            <tr>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Systolic:</label>
                                        <input type="text" class="form-control" value="{{$blood->systolic}}">
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Diastolic:</label>
                                        <input type="text" class="form-control" value="{{$blood->diastolic}}">
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-3"><label class="form-check-label" for="flexCheckDefault">
                                            with treatment
                                        </label>
                                        <input type="checkbox" {{  ($blood->treatment == 1 ? ' checked' : '') }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-3">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            without treatment
                                        </label>
                                        <input type="checkbox" {{  ($blood->treatment == 0 ? ' checked' : '') }}>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table class="no-border" width="100%">
                            <tr>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Pulse rate:</label>
                                        <input type="text" class="form-control" value="{{$blood->pulse_rate}}">
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Extra systoles</label>
                                        <input type="text" class="form-control" value="{{$blood->systoles}}">
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div>
                            <p><em>If the blood pressure is over 140/90 mmHg, please check the reading after ten minutes lying down.</em></p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th>Chest x-ray</th>
                    <th class="text-center" style="width:50px">Normal</th>
                    <th class="text-center" style="width:50px">Abnormal</th>
                    <th style="width:180px">COMMENTS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($chest_xray->chest == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($chest_xray->chest == 2 ? ' checked' : '') }}>

                    </td>
                    <td>{{$chest_xray->comments}}</td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th>ECG</th>
                    <th class="text-center" style="width:50px">Normal</th>
                    <th class="text-center" style="width:50px">Abnormal</th>
                    <th style="width:180px">COMMENTS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($ecg->ecg == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($ecg->ecg == 2 ? ' checked' : '') }}>

                    </td>
                    <td>{{$ecg->comments}}</td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th>CONCLUSIONS</th>
                    <th class="text-center" style="width:50px">YES</th>
                    <th class="text-center" style="width:50px">NO</th>
                    <th style="width:180px">COMMENTS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Do you have any reserves concerning the
                        longevity of the examinee?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($patient->longevity == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($patient->longevity == 0 ? ' checked' : '') }}>

                    </td>
                    </td>
                    <td>{{$patient->comments}}</td>
                </tr>
                <tr>
                    <td>Are there any risks on invalidity or
                        partial, or total disability?</td>
                    <td class="text-center">

                        <input type="checkbox" {{  ($patient->disability == 1 ? ' checked' : '') }}>

                    </td>
                    <td class="text-center">

                        <input type="checkbox" value="" id="flexCheckChecked" {{  ($patient->disability == 0 ? ' checked' : '') }}>

                    </td>
                    <td></td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td colspan="4">
                        <table class="no-border mb-3 mt-2">
                            <tr>
                                <td><b>The proposer’s state of health is Considered to be:</b></td>
                                <td><label class="form-check-label" for="flexCheckDefault">
                                        <b>GOOD</b>
                                    </label>
                                    <input type="checkbox" {{  ($patient->health == 1 ? ' checked' : '') }}>
                                </td>
                                <td><label class="form-check-label" for="flexCheckDefault">
                                        <b>AVERAGE</b>
                                    </label>
                                    <input type="checkbox" {{  ($patient->health == 2 ? ' checked' : '') }}>
                                </td>
                                <td><label class="form-check-label" for="flexCheckDefault">
                                        <b>POOR</b>
                                    </label>
                                    <input type="checkbox" {{  ($patient->health == 3 ? ' checked' : '') }}>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-3" width="100%">
            <thead>
                <tr>
                    <th>RECOMMENDATIONS/ CONCLUSIONS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="mb-3 mt-3 form-wrapper">
                            <label class="form-label" style="line-height: 1.3">Conclusion:</label>
                            <textarea class="form-control" rows="4">{{$patient->conclusion}}</textarea>
                        </div>
                        <div class="mb-3 form-wrapper">
                            <label class="form-label" style="line-height: 1.3">Recommendation:</label>
                            <textarea class="form-control" rows="4">{{$patient->recommendation}}</textarea>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td>
                        <table class="no-border mt-3 mb-2" width="100%">
                            <tr>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Examinees name:</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Signature:</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Examiners name:</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Signature:</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <div class="mb-3 form-wrapper">
                                    <label class="form-label">Date:</label>
                                    <input type="text" class="form-control">
                                </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr style="padding-top: 20px;">
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Doctor's name:</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-3 form-wrapper">
                                        <label class="form-label">Signature:</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <div class="mb-3 form-wrapper">
                                    <label class="form-label">Date:</label>
                                    <input type="text" class="form-control">
                                </div>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>