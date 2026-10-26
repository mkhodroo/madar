@php
use Behin\SimpleWorkflow\Models\Entities\Parts;
use Behin\SimpleWorkflow\Models\Entities\Case_extra_docs;
$parts = Parts::where('case_number', $case->number)->get();
 $extraDocs = Case_extra_docs::where('case_number', $case->number)
     ->where('public_show', 'بله')
     ->get();
 $publicTaskIds = [
     '9f6b7b5c-155e-4698-8b05-26ebb061bb7d',
     '19a1be98-7b4a-4100-903d-e6612c4c4a6c',
     'adee777f-da9d-4d54-bf00-020a27e0f861',
     '9cfbbbf7-e53f-4706-b7c9-c69c0dd84cc4',
     '039a097e-2159-49df-b866-f7766aaf2cfc',
     'd213de29-832b-4de5-8ef1-03295835e5ae',
     'ffa2f261-f3b0-4c7f-b705-1ff46705a118',
     'b9ab688a-7819-4d83-a53a-a396aa540232',
     '8bee90b3-6bc0-4537-86d0-715583566064',
     '0fcd1c57-183e-4c4a-8e5a-b218f972a57d',
     'f9cc1cf5-e3b0-4a46-91a5-2e7e59d29784',
     '36f0f696-5694-4731-a179-a70e9a686ef5',
     'af1b47b1-167f-4371-b028-ac1fe94ee532',
     '19f15a6f-1ec8-488c-adea-6c8419fe850a',
 ];
 $historyRows = $case->getHistoryList()
     ->filter(fn($row) => $row->task && in_array($row->task->id, $publicTaskIds, true))
     ->unique(fn($row) => $row->task->id . '|' . $row->created_at->format('Y-m-d H:i'))
     ->values();
 $currentRow = $historyRows->filter(fn($row) => $row->status === 'new')->last() ?: $historyRows->last();
 $customerName = $case->getVariable('customer_workshop_or_ceo_name') ?: 'ثبت نشده';
 $admissionDate = $case->getVariable('admision_date') ?: 'ثبت نشده';
 $initialDescription = $case->getVariable('initial_description') ?: 'توضیحی ثبت نشده است.';
@endphp

<style>
/* فونت IRANSansX */
@font-face {
    font-family: 'IRANSansX';
    src: url('https://madarpardaz.com/wp-content/uploads/2026/05/IRANSansXFaNum-Bold.woff') format('woff');
    font-weight: 700;
    font-style: normal;
}

@font-face {
    font-family: 'IRANSansX';
    src: url('https://madarpardaz.com/wp-content/uploads/2026/05/IRANSansXFaNum-Black.woff') format('woff');
    font-weight: 900;
    font-style: normal;
}

.service-report,
.service-report * {
    box-sizing: border-box;
}

.service-report {
    --sr-primary: #c22032;
    --sr-primary-dark: #941827;
    --sr-accent: #fed000;
    --sr-ink: #172033;
    --sr-muted: #6b7280;
    --sr-line: #e7eaf0;
    --sr-soft: #f6f7fa;
    --sr-success: #16855b;
    --sr-warning: #b96a05;
    --sr-radius: 18px;
    width: 100%;
    max-width: 1180px;
    margin: 20px auto 40px;
    padding: 0 14px;
    color: var(--sr-ink);
    direction: rtl;
    text-align: right;
    font-family: IRANSansX, Tahoma, Arial, sans-serif;
    line-height: 1.8;
}

.service-report a {
    text-decoration: none;
}

/* ==============================
   شل اصلی - دو ستونه در دسکتاپ
   ============================== */
.service-report-shell {
    display: grid;
    grid-template-columns: 260px 1fr;
    overflow: hidden;
    background: #fff;
    border: 1px solid rgba(23, 32, 51, .08);
    border-radius: 24px;
    box-shadow: 0 18px 55px rgba(20, 31, 54, .09);
    min-height: 600px;
}

/* ==============================
   سایدبار
   ============================== */
.service-report-sidebar {
    background: #f9fafb;
    border-left: 1px solid var(--sr-line);
    padding: 24px 16px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.service-report-sidebar__logo {
    text-align: center;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--sr-line);
    margin-bottom: 8px;
}

.service-report-sidebar__logo img {
    max-width: 140px;
    height: auto;
}

.service-report-nav-wrap {
    flex: 1;
}

.service-report-tabs {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.service-report-tab {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    min-height: 44px;
    padding: 10px 14px;
    border-radius: 10px;
    color: #5f6878;
    font-size: 13px;
    font-weight: 700;
    transition: .2s ease;
    position: relative;
}

.service-report-tab__content {
    display: flex;
    align-items: center;
    gap: 8px;
}

.service-report-tab:hover:not(.active),
.service-report-tab:focus:not(.active) {
    color: var(--sr-primary);
    background: #fff4f5;
    outline: none;
}

.service-report-tab.active {
    color: #fff !important;
    background: var(--sr-primary);
    box-shadow: 0 7px 18px rgba(194, 32, 50, .18);
}

.service-report-tab__count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 22px;
    height: 22px;
    padding: 0 6px;
    border-radius: 999px;
    background: rgba(194, 32, 50, .12);
    color: var(--sr-primary);
    font-size: 11px;
    font-weight: 700;
}

.service-report-tab.active .service-report-tab__count {
    color: var(--sr-primary);
    background: #fff;
    font-weight: 800;
}

/* ==============================
   محتوای اصلی
   ============================== */
.service-report-main {
    display: flex;
    flex-direction: column;
}

/* --- هیرو --- */
.service-report-hero {
    position: relative;
    overflow: hidden;
    padding: 28px 30px 24px;
    color: #000000 !important;
    background: #fed000;
    flex-shrink: 0;
}

.service-report-hero::after {
    content: '';
    position: absolute;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, var(--sr-primary), var(--sr-accent));
}

.service-report-hero__top {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: flex-start;
    gap: 20px;
}

.service-report-hero__info {
    flex: 1;
    min-width: 0;
}

.service-report-kicker { 
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 8px;
    color: rgba(0, 0, 0, .7);
    font-size: 12px;
    font-weight: 600;
}

.service-report-title {
    margin: 0;
    color: #000 !important;
    font-size: 25px;
    font-weight: 800;
    letter-spacing: -.3px;
}

.service-report-subtitle {
    margin: 7px 0 0;
    color: rgba(0, 0, 0, .7);
    font-size: 13px;
}

/* --- استاتوس در هیرو --- */
.service-report-status {
    flex: 0 0 auto;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 38px;
    padding: 7px 13px;
    border: 1px solid rgba(0, 0, 0, .1);
    border-radius: 999px; 
    background: #c22032;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
    align-self: flex-start;
}

.service-report-status__dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: {{ $currentRow && $currentRow->status === 'new' ? '#fed000' : '#42d392' }};
    box-shadow: 0 0 0 5px {{ $currentRow && $currentRow->status === 'new' ? 'rgba(254, 208, 0, .14)' : 'rgba(66, 211, 146, .15)' }};
}

/* --- کارت وضعیت پرونده در هیرو --- */
.service-report-current {
    flex: 1;
    display: flex;
    justify-content: space-between;
    min-width: 0;
    padding: 15px 16px;
    border: 1px solid rgba(0, 0, 0, .08);
    border-radius: 14px;
    background: rgb(255 255 255 / 97%);
}

.service-report-current__label {
    display: block;
    margin-bottom: 5px;
    color: rgba(0, 0, 0, .6);
    font-size: 11px;
    font-weight: 600;
}

.service-report-current__value {
    display: block;
    color: #000;
    font-size: 15px;
    font-weight: 800;
}

.service-report-current__meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px 14px;
    margin-top: 10px;
    color: rgba(0, 0, 0, .6);
    font-size: 10px;
    font-weight: 600;
}

.service-report-current__meta span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* --- سامری کارت‌ها (در هیرو - مخفی در موبایل) --- */
.service-report-summary {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: repeat(3, minmax(125px, 1fr));
    gap: 12px;
    margin-top: 16px;
}

.service-report-stat {
    min-height: 92px;
    padding: 15px 16px;
    border: 1px solid rgba(0, 0, 0, .08);
    border-radius: 14px;
    background: rgb(255 255 255 / 97%);
}

.service-report-stat__label {
    display: block;
    margin-bottom: 5px;
    color: rgba(0, 0, 0, .6);
    font-size: 11px;
    font-weight: 600;
}

.service-report-stat__value {
    display: block;
    color: #000;
    font-size: 18px;
    font-weight: 800;
}

/* --- سامری درون پنل (مخصوص موبایل) --- */
.service-report-summary-inline {
    display: none;
}

/* ==============================
   محتوای تب‌ها
   ============================== */
.service-report-body {
    flex: 1;
    padding: 20px 24px;
    background: #fbfbfc;
    overflow-y: auto;
}

.service-report-panel {
    display: none;
    animation: serviceReportFade .22s ease;
}

.service-report-panel.active {
    display: block;
}

@keyframes serviceReportFade {
    from { opacity: 0; transform: translateY(4px); }
    to { opacity: 1; transform: translateY(0); }
}

/* --- گرید --- */
.service-report-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(80px, 1fr));
    gap: 14px;
}

.service-report-field,
.service-report-section-card,
.service-report-empty {
    border: 1px solid var(--sr-line);
    border-radius: var(--sr-radius);
    background: #fff;
}

.service-report-field {
    min-height: 94px;
    padding: 16px 17px;
}

.service-report-field--wide {
    grid-column: 1 / -1;
}

.service-report-field__label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 7px;
    color: var(--sr-muted);
    font-size: 11px;
    font-weight: 700;
}

.service-report-field__label i {
    color: var(--sr-primary);
}

/* آیکون بزرگتر برای نام مشتری */
.service-report-field--customer .service-report-field__label i {
    font-size: 18px;
}

.service-report-field--customer .service-report-field__value {
    font-size: 16px;
    color: var(--sr-primary-dark);
}

.service-report-field__value {
    color: var(--sr-ink);
    font-size: 14px;
    font-weight: 700;
    overflow-wrap: anywhere;
}

.service-report-description {
    font-weight: 500;
    line-height: 2;
}

.service-report-section-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    margin-bottom: 15px;
}

.service-report-section-title {
    margin: 0;
    color: var(--sr-ink);
    font-size: 16px;
    font-weight: 800;
}

.service-report-section-note {
    margin: 3px 0 0;
    color: var(--sr-muted);
    font-size: 11px;
}

.service-report-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    border-radius: 999px;
    color: var(--sr-primary-dark);
    background: #fff0f2;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}

.service-report-parts {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
}

.service-report-part {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    min-height: 104px;
    padding: 17px;
    border: 1px solid var(--sr-line);
    border-radius: var(--sr-radius);
    background: #fff;
    transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
}

.service-report-part:hover {
    transform: translateY(-2px);
    border-color: rgba(194, 32, 50, .22);
    box-shadow: 0 10px 24px rgba(31, 42, 64, .07);
}

.service-report-part__main {
    display: flex;
    align-items: center;
    gap: 13px;
    min-width: 0;
}

.service-report-part__icon,
.service-report-empty__icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 auto;
    width: 46px;
    height: 46px;
    border-radius: 14px;
    color: var(--sr-primary);
    background: #fff1f3;
    font-size: 19px;
}

.service-report-part__name {
    display: block;
    color: var(--sr-ink);
    font-size: 14px;
    font-weight: 800;
    overflow-wrap: anywhere;
}

.service-report-part__meta {
    display: block;
    margin-top: 2px;
    color: var(--sr-muted);
    font-size: 10px;
}

.service-report-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 38px;
    padding: 7px 12px;
    border: 1px solid #e3e6eb;
    border-radius: 10px;
    color: #424b5c;
    background: #fff;
    font-size: 11px;
    font-weight: 700;
    transition: .2s ease;
    white-space: nowrap;
}

.service-report-action:hover,
.service-report-action:focus {
    color: #fff;
    border-color: var(--sr-primary);
    background: var(--sr-primary);
    outline: none;
}

.service-report-table-wrap {
    width: 100%;
    overflow-x: auto;
    border: 1px solid var(--sr-line);
    border-radius: var(--sr-radius);
    background: #fff;
    -webkit-overflow-scrolling: touch;
}

.service-report-table {
    width: 100%;
    min-width: 620px;
    margin: 0 !important;
    border-collapse: separate;
    border-spacing: 0;
    color: var(--sr-ink);
    font-size: 12px;
}

.service-report-table thead th {
    padding: 13px 16px;
    border: 0 !important;
    border-bottom: 1px solid var(--sr-line) !important;
    color: #687184;
    background: #f7f8fa;
    font-size: 11px;
    font-weight: 800;
    white-space: nowrap;
}

.service-report-table tbody td {
    padding: 14px 16px;
    border: 0 !important;
    border-bottom: 1px solid #eff1f4 !important;
    vertical-align: middle;
}

.service-report-table tbody tr:last-child td {
    border-bottom: 0 !important;
}

.service-report-table tbody tr:hover {
    background: #fffafb;
}

.service-report-table a {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--sr-primary);
    font-weight: 700;
}

.service-report-timeline {
    position: relative;
    margin: 4px 0 0;
    padding: 0 0 0;
    list-style: none;
}

.service-report-timeline::before {
    content: '';
    position: absolute;
    top: 14px;
    right: 17px;
    bottom: 14px;
    width: 2px;
    background: #e3e7ed;
}

.service-report-timeline__item {
    position: relative;
    display: grid;
    grid-template-columns: 36px minmax(0, 1fr) auto;
    align-items: center;
    gap: 12px;
    min-height: 72px;
    padding: 10px 0; 
}

.service-report-timeline__marker {
    position: relative;
    z-index: 2;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border: 5px solid #fbfbfc;
    border-radius: 50%;
    color: #fff;
    background: #a8afbb;
    font-size: 11px;
}

.service-report-timeline__item.is-done .service-report-timeline__marker {
    background: var(--sr-success);
}

.service-report-timeline__item.is-current .service-report-timeline__marker {
    color: #5a4200;
    background: var(--sr-accent);
    box-shadow: 0 0 0 4px rgba(254, 208, 0, .14);
}

.service-report-timeline__content {
    min-width: 0;
    padding: 13px 15px;
    border: 1px solid var(--sr-line);
    border-radius: 14px;
    background: #fff;
}

.service-report-timeline__title {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    margin: 0;
    color: var(--sr-ink);
    font-size: 13px;
    font-weight: 800;
}

.service-report-timeline__badge {
    display: inline-flex;
    align-items: center;
    min-height: 23px;
    padding: 2px 8px;
    border-radius: 999px;
    color: #795900;
    background: #fff2b8;
    font-size: 9px;
    font-weight: 800;
}

.service-report-timeline__date {
    direction: ltr;
    color: var(--sr-muted);
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.service-report-empty {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    min-height: 210px;
    padding: 24px;
    color: var(--sr-muted);
    text-align: center;
}

.service-report-empty__icon {
    width: 54px;
    height: 54px;
    margin-bottom: 12px;
    color: #7a8495;
    background: #f0f2f5;
}

.service-report-empty strong {
    display: block;
    margin-bottom: 4px;
    color: #3e4757;
    font-size: 13px;
}

/* --- موبایل هدر --- */
.service-report-mobile-header {
    display: none;
}

/* --- نویگیشن موبایل (sticky bottom) --- */
.service-report-nav-wrap.mobile-nav {
    display: none;
}

.service-report-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    padding: 15px 24px;
    border-top: 1px solid var(--sr-line);
    color: var(--sr-muted);
    background: #fff;
    font-size: 10px;
}

.service-report-print {
    display: none;
    align-items: center;
    gap: 7px;
    color: #4d5666;
    font-weight: 700;
    cursor: pointer;
}

/* ==============================
   رسپانسیو - تبلت
   ============================== */
@media (max-width: 991.98px) {
    .service-report-shell {
        grid-template-columns: 220px 1fr;
    }
    
    .service-report-sidebar {
        padding: 20px 12px;
    }
    
    .service-report-sidebar__logo img {
        max-width: 110px;
    }
    
    .service-report-tab {
        padding: 8px 10px;
        font-size: 12px;
    }
    
    .service-report-body {
        padding: 16px;
    }
    
    .service-report-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    }
    }
    @media (min-width: 767.98px) {
    .service-report-hero-mobile .service-report-current{
        display:none;
    }
    }
/* ==============================
   رسپانسیو - موبایل
   ============================== */
@media (max-width: 767.98px) {
    .service-report {
        margin-top: 0;
        padding: 0;
        max-width: 100%;
    }
    /* --- هدر ثابت موبایل --- */
    .service-report-mobile-header {
        display: flex !important;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 1000;
        background: #fff;
        padding: 10px 16px;
        border-bottom: 1px solid var(--sr-line);
        box-shadow: 0 2px 12px rgba(22, 31, 49, .06);
    }
    
    .service-report-mobile-header__logo {
        flex-shrink: 0;
    }
    
    .service-report-mobile-header__logo img {
        height: 32px;
        width: auto;
    }
    
    .service-report-mobile-header__status {
        font-size: 11px;
        background: #c22032;
        font-weight: 700;
        color: white;
        display: flex;
        padding: 6px 10px;
        border-radius: 6px;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }
    
    .service-report-mobile-header__status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: {{ $currentRow && $currentRow->status === 'new' ? '#fed000' : '#42d392' }};
        display: inline-block;
        flex-shrink: 0;
    }
    
    /* --- شل موبایل --- */
    .service-report-shell {
        display: block;
        border-radius: 0;
        border: none;
        box-shadow: none;
    }
    
    /* --- سایدبار مخفی --- */
    .service-report-sidebar {
        display: none;
    }
    
    /* --- هیرو بخشی از خلاصه پرونده (فقط در پنل overview) --- */
    .service-report-hero {
        display: none;
    }
    
    /* --- سامری اینلاین در پنل overview --- */
    .service-report-summary-inline {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 8px;
        margin-bottom: 16px;
    }
    
    .service-report-summary-inline .service-report-stat {
        min-height: 70px;
        padding: 12px 10px;
        border: 1px solid var(--sr-line);
        border-radius: 14px;
        background: #fff;
    }
    
    .service-report-summary-inline .service-report-stat__label {
        font-size: 10px;
    }
    
    .service-report-summary-inline .service-report-stat__value {
        font-size: 14px;
    }
    
    /* --- کارت وضعیت پرونده در موبایل --- */
    .service-report-hero-mobile {
        display: block;
        background: #fed000;
        padding: 8px;
        border-radius: 14px;
        margin-bottom: 36px;
    }
    
    .service-report-hero-mobile .service-report-current {
        width: 100%;
        background: rgb(255 255 255 / 97%);
        border: 1px solid rgba(0, 0, 0, .08);
        border-radius: 12px;
        padding: 12px 14px;
    }
    
    .service-report-hero-mobile .service-report-current__label {
        font-size: 10px;
    }
    
    .service-report-hero-mobile .service-report-current__value {
        font-size: 14px;
    }
    
    .service-report-hero-mobile .service-report-current__meta {
        font-size: 9px;
        margin-top: 6px;
    }
    
    .service-report-body {
        padding: 16px 12px 100px;
        background: #fbfbfc;
        min-height: 80vh;
    }
    
    .service-report-grid,
    .service-report-parts {
        grid-template-columns: 1fr;
    }
    
    .service-report-part {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .service-report-action {
        width: 100%;
    }
    
    .service-report-timeline__item {
        grid-template-columns: 36px minmax(0, 1fr);
    }
    
    .service-report-timeline__date {
        grid-column: 2;
        margin-top: -5px;
        padding-right: 15px;
    }
    
    /* --- نویگیشن پایین صفحه --- */
    .service-report-nav-wrap.mobile-nav {
        display: block;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        padding: 6px 8px 10px;
        background: white;
        backdrop-filter: blur(20px);
        border-top: 1px solid var(--sr-line);
        box-shadow: 0 -4px 20px rgba(22, 31, 49, .08);
        border-radius:0;
    }
    
    .service-report-nav-wrap.mobile-nav .service-report-tabs-scroll {
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    
    .service-report-nav-wrap.mobile-nav .service-report-tabs-scroll::-webkit-scrollbar {
        display: none;
    }
    
    .service-report-nav-wrap.mobile-nav .service-report-tabs {
        flex-direction: row;
        justify-content: space-between;
        gap: 0;
        padding: 0;
    }
    
    .service-report-nav-wrap.mobile-nav .service-report-tab {
        flex: 1;
        flex-direction: column;
        gap: 3px;
        min-height: 50px;
        padding: 15px 25px;
        font-size: 13px;
        text-align: center;
        justify-content: center;
        border:1px solid;
        border-color: #11111120;
        border-radius: 8px;
        position: relative;
        min-width: 0;
        background: #ffffff80;
        color: #8a8f9a;
    }
    
    .service-report-nav-wrap.mobile-nav .service-report-tab__content {
        flex-direction: column;
        gap: 2px;
    }
    
    .service-report-nav-wrap.mobile-nav .service-report-tab i {
        font-size: 18px;
        opacity: .5;
        transition: .2s ease;
    }
    
    .service-report-nav-wrap.mobile-nav .service-report-tab.active {
        color: white !important;
        background: #c22032 !important;
        box-shadow: none !important;
    }
    
    .service-report-nav-wrap.mobile-nav .service-report-tab.active i {
        opacity: 1;
        color: var(--sr-primary);
    }
    
    .service-report-nav-wrap.mobile-nav .service-report-tab__count {
        position: absolute;
        top: 2px;
        right: 50%;
        transform: translateX(50%);
        min-width: 15px;
        height: 15px;
        font-size: 8px;
        padding: 0 4px;
        background: var(--sr-primary);
        color: #fff;
    }
    
    .service-report-nav-wrap.mobile-nav .service-report-tab.active .service-report-tab__count {
        background: var(--sr-primary);
        color: #fff;
    }
    
    .service-report-footer {
        padding: 13px 16px 20px;
        font-size: 9px;
        flex-direction: column;
        align-items: flex-start;
    }
}

/* ==============================
   پرینت
   ============================== */
@media print {
    .service-report {
        max-width: none;
        margin: 0;
        padding: 0;
    }
    
    .service-report-shell {
        display: block;
        border: 0;
        box-shadow: none;
    }
    
    .service-report-sidebar,
    .service-report-nav-wrap,
    .service-report-mobile-header,
    .service-report-print {
        display: none !important;
    }
    
    .service-report-body {
        padding: 20px 0;
        background: #fff;
    }
    
    .service-report-panel {
        display: block !important;
        margin-bottom: 28px;
        page-break-inside: avoid;
    }
    
    .service-report-panel::before {
        content: attr(data-print-title);
        display: block;
        margin-bottom: 12px;
        font-size: 17px;
        font-weight: 800;
    }
}
</style>

<!-- هدر ثابت مخصوص موبایل -->
<header class="service-report-mobile-header">
    <div class="service-report-mobile-header__logo">
        <img src="https://madarpardaz.com/wp-content/uploads/2024/10/logo.png" alt="مدارپرداز" />
    </div>
    <div class="service-report-mobile-header__status">
        <span class="service-report-mobile-header__status-dot"></span>
        آخرین وضعیت: {{ $currentRow && $currentRow->task ? $currentRow->task->name : 'ثبت نشده' }}
    </div>
</header>

<section class="service-report" dir="rtl" aria-label="گزارش وضعیت سرویس">
    <div class="service-report-shell">
        <!-- ========== سایدبار دسکتاپ ========== -->
        <aside class="service-report-sidebar">
            <div class="service-report-sidebar__logo">
                <img src="https://madarpardaz.com/wp-content/uploads/2024/10/logo.png" alt="مدارپرداز" />
            </div>
            <div class="service-report-nav-wrap">
                <nav aria-label="بخش‌های گزارش">
                    <ul class="service-report-tabs" role="tablist">
                        <li role="presentation">
                            <a href="#service-report-overview" class="service-report-tab active" data-report-tab="service-report-overview" role="tab" aria-selected="true">
                                <span class="service-report-tab__content">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    خلاصه پرونده
                                </span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#service-report-parts" class="service-report-tab" data-report-tab="service-report-parts" role="tab" aria-selected="false">
                                <span class="service-report-tab__content">
                                    <i class="fa fa-cogs" aria-hidden="true"></i>
                                    قطعات
                                </span>
                                <span class="service-report-tab__count">{{ $parts->count() }}</span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#service-report-files" class="service-report-tab" data-report-tab="service-report-files" role="tab" aria-selected="false">
                                <span class="service-report-tab__content">
                                    <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                    مستندات تست
                                </span>
                                <span class="service-report-tab__count">{{ $extraDocs->count() }}</span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#service-report-history" class="service-report-tab" data-report-tab="service-report-history" role="tab" aria-selected="false">
                                <span class="service-report-tab__content">
                                    <i class="fa fa-history" aria-hidden="true"></i>
                                    روند عملیات
                                </span>
                                <span class="service-report-tab__count">{{ $historyRows->count() }}</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- ========== محتوای اصلی (دسکتاپ) ========== -->
        <div class="service-report-main">
            <header class="service-report-hero">
                <div class="service-report-hero__top">
                    <div class="service-report-hero__info">
                        <div class="service-report-kicker">
                            <i class="fa fa-wrench" aria-hidden="true"></i>
                            سامانه پیگیری خدمات مدارپرداز
                        </div>
                        <h1 class="service-report-title">گزارش وضعیت سرویس</h1>
                        <p class="service-report-subtitle">آخرین وضعیت ثبت‌شده، مشخصات پذیرش، مستندات و سوابق عملیات</p>
                    </div>
                    <div class="service-report-current">
                        <div class="service-report-current-text">
                            <span class="service-report-current__label">وضعیت پرونده</span>
                            <strong class="service-report-current__value">
                                {{ $currentRow && $currentRow->task ? $currentRow->task->name : 'هنوز رویدادی ثبت نشده است' }}
                            </strong>
                            <div class="service-report-current__meta">
                                @if ($currentRow)
                                    <span>
                                        <i class="fa fa-calendar-o" aria-hidden="true"></i>
                                        {{ toJalali($currentRow->created_at)->format('Y-m-d H:i') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="service-report-status" aria-label="وضعیت کلی پرونده">
                            <span class="service-report-status__dot"></span>
                            {{ $currentRow && $currentRow->status === 'new' ? 'در حال انجام' : 'آخرین وضعیت ثبت‌شده' }}
                        </div>
                    </div>
                </div>
                <div class="service-report-summary">
                    <div class="service-report-stat">
                        <span class="service-report-stat__label">شماره پرونده</span>
                        <strong class="service-report-stat__value">{{ $case->number }}</strong>
                    </div>
                    <div class="service-report-stat">
                        <span class="service-report-stat__label">تاریخ پذیرش</span>
                        <strong class="service-report-stat__value">{{ $admissionDate }}</strong>
                    </div>
                    <div class="service-report-stat">
                        <span class="service-report-stat__label">تعداد قطعات</span>
                        <strong class="service-report-stat__value">{{ $parts->count() }}</strong>
                    </div>
                </div>
            </header>

            <main class="service-report-body">
                <section id="service-report-overview" class="service-report-panel active" data-print-title="خلاصه پرونده" role="tabpanel">
                    <!-- --- کارت وضعیت (فقط موبایل) --- -->
                    <div class="service-report-hero-mobile">
                        <div class="service-report-current">
                            <div>
                            <span class="service-report-current__label">وضعیت پرونده</span>
                            <strong class="service-report-current__value">
                                {{ $currentRow && $currentRow->task ? $currentRow->task->name : 'هنوز رویدادی ثبت نشده است' }}
                            </strong>
                            </div>
                            <div class="service-report-current__meta">
                                @if ($currentRow)
                                    <span>
                                        <i class="fa fa-calendar-o" aria-hidden="true"></i>
                                        {{ toJalali($currentRow->created_at)->format('Y-m-d H:i') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- --- سامری اینلاین (فقط موبایل) --- -->
                    <div class="service-report-section-head">
                        <div>
                            <h2 class="service-report-section-title">اطلاعات اصلی پذیرش</h2>
                            <p class="service-report-section-note">اطلاعاتی که هنگام ثبت پرونده دریافت شده است.</p>
                        </div>
                        <span class="service-report-chip"><i class="fa fa-user"></i> مشخصات مشتری</span>
                    </div>
                    <div class="service-report-grid">
                        <div class="service-report-field service-report-field--customer">
                            <span class="service-report-field__label"><i class="fa fa-user-circle-o"></i> نام مشتری / مجموعه</span>
                            <div class="service-report-field__value">{{ $customerName }}</div>
                        </div>
                        <div class="service-report-field">
                            <span class="service-report-field__label"><i class="fa fa-calendar-check-o"></i> تاریخ پذیرش</span>
                            <div class="service-report-field__value">{{ $admissionDate }}</div>
                        </div>
                        <div class="service-report-field">
                            <span class="service-report-field__label"><i class="fa fa-folder-open-o"></i> شماره پرونده</span>
                            <div class="service-report-field__value">{{ $case->number }}</div>
                        </div>
                        <div class="service-report-field">
                            <span class="service-report-field__label"><i class="fa fa-cogs"></i> قطعات پذیرش‌شده</span>
                            <div class="service-report-field__value">{{ $parts->count() }} قطعه</div>
                        </div>
                        <div class="service-report-field service-report-field--wide">
                            <span class="service-report-field__label"><i class="fa fa-commenting-o"></i> توضیحات اولیه مشتری</span>
                            <div class="service-report-field__value service-report-description">{{ $initialDescription }}</div>
                        </div>
                    </div>
                </section>

                <section id="service-report-parts" class="service-report-panel" data-print-title="قطعات پذیرش‌شده" role="tabpanel">
                    <div class="service-report-section-head">
                        <div>
                            <h2 class="service-report-section-title">قطعات پذیرش‌شده</h2>
                            <p class="service-report-section-note">فهرست تجهیزات یا قطعات ثبت‌شده در این پرونده.</p>
                        </div>
                        <span class="service-report-chip">{{ $parts->count() }} قطعه</span>
                    </div>
                    @if ($parts->count())
                        <div class="service-report-parts">
                            @foreach ($parts as $part)
                                <article class="service-report-part">
                                    <div class="service-report-part__main">
                                        <span class="service-report-part__icon"><i class="fa fa-microchip" aria-hidden="true"></i></span>
                                        <div>
                                            <strong class="service-report-part__name">{{ $part->name }}</strong>
                                            <span class="service-report-part__meta">قطعه شماره {{ $loop->iteration }}</span>
                                        </div>
                                    </div>
                                    @if ($part->initial_part_pic)
                                        <a class="service-report-action" href="{{ url($part->initial_part_pic) }}" target="_blank" rel="noopener" download aria-label="مشاهده یا دانلود تصویر اولیه {{ $part->name }}">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            تصویر اولیه
                                        </a>
                                    @else
                                        <span class="service-report-chip">بدون تصویر</span>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="service-report-empty">
                            <span class="service-report-empty__icon"><i class="fa fa-cogs"></i></span>
                            <strong>قطعه‌ای ثبت نشده است</strong>
                            <span>در حال حاضر قطعه‌ای برای نمایش در این پرونده وجود ندارد.</span>
                        </div>
                    @endif
                </section>

                <section id="service-report-files" class="service-report-panel" data-print-title="تصاویر و ویدیوهای تست" role="tabpanel">
                    <div class="service-report-section-head">
                        <div>
                            <h2 class="service-report-section-title">تصاویر و ویدیوهای تست دستگاه</h2>
                            <p class="service-report-section-note">مستندات عمومی ثبت‌شده توسط واحد فنی.</p>
                        </div>
                        <span class="service-report-chip">{{ $extraDocs->count() }} فایل</span>
                    </div>
                    @if ($extraDocs->count())
                        <div class="table-responsive service-report-table-wrap">
                            <table class="table service-report-table">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;">ردیف</th>
                                        <th>نام فایل</th>
                                        <th style="width: 190px;">مشاهده / دریافت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($extraDocs as $doc)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $doc->name }}</td>
                                            <td>{!! $doc->fileLink() !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="service-report-empty">
                            <span class="service-report-empty__icon"><i class="fa fa-file-image-o"></i></span>
                            <strong>مستنداتی برای نمایش وجود ندارد</strong>
                            <span>پس از انتشار تصاویر یا ویدیوهای تست، فایل‌ها در این بخش نمایش داده می‌شوند.</span>
                        </div>
                    @endif
                </section>

                <section id="service-report-history" class="service-report-panel" data-print-title="تاریخچه عملیات" role="tabpanel">
                    <div class="service-report-section-head">
                        <div>
                            <h2 class="service-report-section-title">روند انجام عملیات</h2>
                            <p class="service-report-section-note">رویدادهای ثبت‌شده و قابل نمایش برای کارفرما، بدون محاسبه درصد پیشرفت.</p>
                        </div>
                        <span class="service-report-chip">{{ $historyRows->count() }} رویداد ثبت‌شده</span>
                    </div>
                    @if ($historyRows->count())
                        <ol class="service-report-timeline">
                            @foreach ($historyRows as $row)
                                <li class="service-report-timeline__item {{ $row->status === 'done' ? 'is-done' : 'is-current' }}">
                                    <span class="service-report-timeline__marker" aria-hidden="true">
                                        <i class="fa {{ $row->status === 'done' ? 'fa-check' : 'fa-clock-o' }}"></i>
                                    </span>
                                    <div class="service-report-timeline__content">
                                        <h3 class="service-report-timeline__title">
                                            {{ $row->task->name }}
                                            @if ($row->status === 'new')
                                                <span class="service-report-timeline__badge">در حال انجام</span>
                                            @endif
                                        </h3>
                                    </div>
                                    <time class="service-report-timeline__date" datetime="{{ $row->created_at->format('Y-m-d H:i') }}">
                                        {{ toJalali($row->created_at)->format('Y-m-d H:i') }}
                                    </time>
                                </li>
                            @endforeach
                        </ol>
                    @else
                        <div class="service-report-empty">
                            <span class="service-report-empty__icon"><i class="fa fa-history"></i></span>
                            <strong>هنوز عملیاتی ثبت نشده است</strong>
                            <span>تاریخچه مراحل انجام سرویس در این بخش نمایش داده خواهد شد.</span>
                        </div>
                    @endif
                </section>
            </main>

            <footer class="service-report-footer">
                <span>این گزارش به‌صورت خودکار از آخرین اطلاعات ثبت‌شده در پرونده تولید شده است.</span>
                <a href="#" class="service-report-print" data-report-print>
                    <i class="fa fa-print" aria-hidden="true"></i>
                    چاپ گزارش
                </a>
            </footer>
        </div>
    </div>
</section>

<!-- نویگیشن موبایل (sticky bottom) - فقط در موبایل نمایش داده می‌شود -->
<nav class="service-report-nav-wrap mobile-nav" aria-label="بخش‌های گزارش">
    <div class="service-report-tabs-scroll">
        <ul class="service-report-tabs" role="tablist">
            <li role="presentation">
                <a href="#service-report-overview" class="service-report-tab active" data-report-tab="service-report-overview" role="tab" aria-selected="true">
                    <span class="service-report-tab__content">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        خلاصه
                    </span>
                </a>
            </li>
            <li role="presentation">
                <a href="#service-report-parts" class="service-report-tab" data-report-tab="service-report-parts" role="tab" aria-selected="false">
                    <span class="service-report-tab__content">
                        <i class="fa fa-cogs" aria-hidden="true"></i>
                        قطعات
                    </span>
                    <span class="service-report-tab__count">{{ $parts->count() }}</span>
                </a>
            </li>
            <li role="presentation">
                <a href="#service-report-files" class="service-report-tab" data-report-tab="service-report-files" role="tab" aria-selected="false">
                    <span class="service-report-tab__content">
                        <i class="fa fa-file-image-o" aria-hidden="true"></i>
                        مستندات
                    </span>
                    <span class="service-report-tab__count">{{ $extraDocs->count() }}</span>
                </a>
            </li>
            <li role="presentation">
                <a href="#service-report-history" class="service-report-tab" data-report-tab="service-report-history" role="tab" aria-selected="false">
                    <span class="service-report-tab__content">
                        <i class="fa fa-history" aria-hidden="true"></i>
                        روند
                    </span>
                    <span class="service-report-tab__count">{{ $historyRows->count() }}</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<script>
$(document).ready(function() {
    $('#done-container').remove();
    $('#button-container').remove();

    // مدیریت کلیک روی تب‌ها (هم سایدبار هم نویگیشن موبایل)
    $('[data-report-tab]').on('click', function(event) {
        event.preventDefault();

        var targetId = $(this).attr('data-report-tab');
        
        // به‌روزرسانی همه تب‌ها در هر دو ناحیه
        $('[data-report-tab]')
            .removeClass('active')
            .attr('aria-selected', 'false');

        $('[data-report-tab="' + targetId + '"]')
            .addClass('active')
            .attr('aria-selected', 'true');

        // نمایش پنل مربوطه
        $('.service-report-panel').removeClass('active');
        $('#' + targetId).addClass('active');
        
        // در موبایل: اسکرول به بالای پنل
        if (window.innerWidth <= 767) {
            var headerHeight = $('.service-report-mobile-header').outerHeight() || 0;
            $('html, body').animate({
                scrollTop: $('#' + targetId).offset().top - headerHeight - 10
            }, 300);
        }
    });

    // مدیریت پرینت
    $('.service-report [data-report-print]').on('click', function(event) {
        event.preventDefault();
        window.print();
    });
    
    // تنظیم padding-bottom برای محتوا و فوتر در موبایل
    function adjustMobilePadding() {
        if (window.innerWidth <= 767) {
            var navHeight = $('.service-report-nav-wrap.mobile-nav').outerHeight() || 10;
            $('.service-report-body').css('padding-bottom', (navHeight + 20) + 'px');
            $('.service-report-footer').css('padding-bottom', (20) + 'px');
        } else {
            $('.service-report-body').css('padding-bottom', '');
            $('.service-report-footer').css('padding-bottom', '');
        }
    }
    
    adjustMobilePadding();
    $(window).resize(adjustMobilePadding);
});
</script>