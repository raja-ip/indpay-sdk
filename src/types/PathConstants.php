<?php

class PathConstants {
    const SCHEME = "https";

    const AUTH_HEADER_KEY = "Authorization";

    const COLLECT_PATH = "apis";
    const PAYOUTS_PATH = "payouts";

    const PAYOUTS_PORT = 4052;
    const UPI_PORT = 4051;

    const MEDIA_TYPE_JSON = "application/json; charset=utf-8";
    const MEDIA_TYPE_FORM_DATA = "application/x-www-form-urlencoded";

    const ADD_BENE = "payouts/api/v1/ind/p1/beneficiary/add";
    const BENE_LIST = "payouts/api/v1/ind/p1/beneficiary/list";
    const PO_BULK = "payouts/api/v1/ind/p1/payouts";
    const PO_SINGLE = "payouts/api/v1/ind/p1/payouts/single";
    const PO_STATUS = "payouts/api/v1/ind/p1/payouts/status";
    const VPA_VERIFY = "api/v1/upi/t1/verify/vpa";
    const RAISE_COLLECT = "api/v1/upi/t1/payment/upi/raise-collect";
    const COLLECT_STATUS = "api/v1/upi/t1/status/upi/raise-collect";
    const QR_DYNAMIC = "api/v1/upi/t1/payment/upi/qr/dynamic";
    const QR_STATIC = "api/v1/upi/t1/payment/upi/qr/static";
    const QR_STATUS = "api/v1/upi/t1/status/upi/qr";
    const RRN_STATUS = "api/v1/upi/t1/status/upi/qr/rrn";
    const INTENT = "api/v1/upi/t1/payment/upi/link/intent";
    const CREATE_ORDER = "api/v1/order/create";
}
