<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Laralink">
    <!-- Site Title -->
    <title>Purchase Invoice = {{ $purchase_summary->purchase_invoice_no }}</title>
    <link rel="stylesheet" href="{{ asset('admin/invoice') }}/style.css">
</head>

<body>
    <div class="tm_container">
        <div class="tm_invoice_wrap">
            <div class="tm_invoice tm_style1 tm_type1" id="tm_download_section">
                <div class="tm_invoice_in">
                    <div class="tm_invoice_head tm_top_head tm_mb15 tm_align_center">
                        <div class="tm_invoice_left">
                            <div class="tm_logo"><img src="{{ asset('uploads/default_photo') }}/{{ $default_setting->logo_photo }}" alt="Logo"></div>
                        </div>
                        <div class="tm_invoice_right tm_text_right tm_mobile_hide">
                            <div class="tm_f50 tm_text_uppercase tm_white_color">Invoice</div>
                        </div>
                        <div class="tm_shape_bg tm_accent_bg tm_mobile_hide"></div>
                    </div>
                    <div class="tm_invoice_info tm_mb25">
                        <div class="tm_card_note tm_mobile_hide"><b class="tm_primary_color">Payment Status: </b>{{ $purchase_summary->payment_status }}</div>
                        <div class="tm_invoice_info_list tm_white_color">
                            <p class="tm_invoice_number tm_m0">Invoice No: <b>#{{ $purchase_summary->purchase_invoice_no }}</b></p>
                            <p class="tm_invoice_date tm_m0">Date: <b>{{ $purchase_summary->purchase_date }}</b></p>
                        </div>
                        <div class="tm_invoice_seperator tm_accent_bg"></div>
                    </div>
                    <div class="tm_invoice_head tm_mb10">
                        <div class="tm_invoice_left">
                            <p class="tm_mb2"><b class="tm_primary_color">Supplier info:</b></p>
                            <p>
                                {{ $purchase_summary->relationtosupplier->supplier_name }}<br>
                                {{ $purchase_summary->relationtosupplier->supplier_address }}<br>
                                {{ $purchase_summary->relationtosupplier->supplier_phone_number }}<br>
                                {{ $purchase_summary->relationtosupplier->supplier_email }}
                            </p>
                        </div>
                        <div class="tm_invoice_right tm_text_right">
                            <p class="tm_mb2"><b class="tm_primary_color">Company info:</b></p>
                            <p>
                                {{ $default_setting->app_name }} <br>
                                {{ $default_setting->address }}<br>
                                {{ $default_setting->support_phone }}<br>
                                {{ $default_setting->support_email }}
                            </p>
                        </div>
                    </div>
                    <div class="tm_table tm_style1">
                        <div class="">
                            <div class="tm_table_responsive">
                                <table>
                                    <thead>
                                        <tr class="tm_accent_bg">
                                        <th class="tm_width_4 tm_semi_bold tm_white_color">Item</th>
                                        <th class="tm_width_2 tm_semi_bold tm_white_color">Price</th>
                                        <th class="tm_width_1 tm_semi_bold tm_white_color">Qty</th>
                                        <th class="tm_width_2 tm_semi_bold tm_white_color tm_text_right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchase_details as $purchase_detail)
                                        <tr>
                                        <td class="tm_width_4">{{ $purchase_detail->relationtoproduct->product_name }}</td>
                                        <td class="tm_width_2">{{ $purchase_detail->purchase_quantity }}</td>
                                        <td class="tm_width_1">{{ $purchase_detail->purchase_price }}</td>
                                        <td class="tm_width_2 tm_text_right">{{ $purchase_detail->purchase_quantity * $purchase_detail->purchase_price }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tm_invoice_footer tm_border_top tm_mb15 tm_m0_md">
                            <div class="tm_left_footer">
                                <p class="tm_mb2"><b class="tm_primary_color">Payment info:</b></p>
                                <div class="table-responsive">
                                    <table class="table table-primary">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Method</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($payment_summaries as $payment_summary)
                                            <tr>
                                                <td>{{ $payment_summary->created_at->format('d-M-Y') }}</td>
                                                <td>{{ $payment_summary->payment_method }}</td>
                                                <td>{{ $payment_summary->payment_amount }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tm_right_footer">
                                <table class="tm_mb15">
                                    <tbody>
                                        <tr class="tm_gray_bg ">
                                            <td class="tm_width_3 tm_primary_color tm_bold">Subtoal</td>
                                            <td class="tm_width_3 tm_primary_color tm_bold tm_text_right">{{ $purchase_summary->sub_total }}</td>
                                        </tr>
                                        <tr class="tm_gray_bg">
                                            <td class="tm_width_3 tm_primary_color">Discount<span class="tm_ternary_color"></span></td>
                                            <td class="tm_width_3 tm_primary_color tm_text_right">{{ $purchase_summary->discount }}</td>
                                        </tr>
                                        <tr class="tm_accent_bg">
                                            <td class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_white_color">Grand Total</td>
                                            <td class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_white_color tm_text_right">{{ $purchase_summary->grand_total }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($purchase_summary->payment_status != "Paid")
                        <div class="tm_invoice_footer tm_type1">
                            <div class="tm_left_footer"></div>
                            <div class="tm_right_footer">
                                <div class="tm_sign tm_text_center">
                                    <p class="tm_m0 tm_ternary_color tm_bold">Due Amount</p>
                                    <p class="tm_m0 tm_f16 tm_primary_color tm_bold">{{ $purchase_summary->grand_total - $purchase_summary->payment_amount }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="tm_note tm_text_center tm_font_style_normal">
                        <hr class="tm_mb15">
                        <p class="tm_mb2"><b class="tm_primary_color">Note:</b></p>
                        <p class="tm_m0">This invoice is system generated so signature not required.</p>
                    </div>
                </div>
            </div>
            <div class="tm_invoice_btns tm_hide_print">
                <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
                <span class="tm_btn_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><circle cx="392" cy="184" r="24" fill='currentColor'/></svg>
                </span>
                <span class="tm_btn_text">Print</span>
                </a>
                <button id="tm_download_btn" class="tm_invoice_btn tm_color2">
                    <span class="tm_btn_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
                    </span>
                    <span class="tm_btn_text">Download</span>
                </button>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin/invoice') }}/jquery.min.js"></script>
    <script src="{{ asset('admin/invoice') }}/jspdf.min.js"></script>
    <script src="{{ asset('admin/invoice') }}/html2canvas.min.js"></script>
    <script src="{{ asset('admin/invoice') }}/main.js"></script>
</body>
</html>
