const Ajax = {
    post(e, a, t, r, s = "") {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        }),
            $.ajax({
                type: "POST",
                url: e,
                data: a,
                dataType: "json",
                beforeSend: s,
                success: t,
                error: r,
            });
    },
    postWithFile: (a, b, c, d, e = "") => {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: a,
            data: b,
            contentType: false,
            processData: false,
            beforeSend: e,
            success: c,
            error: d,
        });
    },
};
