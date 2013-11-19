namespace php York.Thrift.Commons

exception TRuntimeException {
    1:i32 code,
    2:string message,
}

struct DateTimeRange {
    1:string startDateTime,
    2:string endDateTime,
}

enum SortOrder {
    ORDER_DESC = 1,
    ORDER_ASC = 2,
}
