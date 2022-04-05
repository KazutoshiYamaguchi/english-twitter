window.onload = function () {
    //- 改行に合わせてテキストエリアのサイズ変更
    this.resizeTextarea = () => {
        // textarea要素のpaddingのY軸(高さ)
        const PADDING_Y = 20;

        // textarea要素
        const $textarea = document.getElementById("textarea");

        // textareaそ要素のlineheight
        let lineHeight = getComputedStyle($textarea).lineHeight;
        // "19.6px" のようなピクセル値が返ってくるので、数字だけにする
        lineHeight = lineHeight.replace(/[^-\d\.]/g, "");

        // textarea要素に入力された値の行数
        const lines = ($textarea.value + "\n").match(/\n/g).length;

        // 高さを再計算
        $textarea.style.height = lineHeight * lines + PADDING_Y + "px";
    };
};
