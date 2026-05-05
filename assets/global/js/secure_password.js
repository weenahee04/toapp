(function ($) {
    "use strict";

    const scorePassword = (value) => {
        let score = 0;
        if (value.length >= 6) score += 1;
        if (value.length >= 10) score += 1;
        if (/[a-z]/.test(value) && /[A-Z]/.test(value)) score += 1;
        if (/\d/.test(value)) score += 1;
        if (/[^A-Za-z0-9]/.test(value)) score += 1;
        return Math.min(score, 5);
    };

    const labels = ["Too weak", "Weak", "Fair", "Good", "Strong", "Excellent"];
    const colors = ["#d94f3d", "#d94f3d", "#d98b22", "#0e90b5", "#18a46f", "#18a46f"];

    $(".secure-password").each(function () {
        const input = $(this);

        if (input.data("secure-password-ready")) {
            return;
        }

        input.data("secure-password-ready", true);

        const meter = $(`
            <div class="password-meter" aria-live="polite">
                <div class="password-meter__track"><span></span></div>
                <small class="password-meter__label">Use at least 6 characters.</small>
            </div>
        `);

        input.closest(".auth-password-wrap").length
            ? input.closest(".auth-password-wrap").after(meter)
            : input.after(meter);

        input.on("input", function () {
            const score = scorePassword(input.val());
            const width = Math.max(score * 20, input.val() ? 12 : 0);
            meter.find(".password-meter__track span").css({
                width: `${width}%`,
                backgroundColor: colors[score],
            });
            meter.find(".password-meter__label").text(input.val() ? labels[score] : "Use at least 6 characters.");
        });
    });
})(jQuery);
