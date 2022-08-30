<h1>会員情報登録フォーム</h1>
<form action="" method="post">
    <!-- 氏名フォーム -->
    <p>
        氏名　
        姓
        <input type="text" name="nameSei">
        名
        <input type="text" name="nameMei">
    </p>
    <!-- 性別選択 -->
    <p>
        性別　
        <label><input type="radio" name="gender" value="1">男性</label>
        <label><input type="radio" name="gender" value="2">女性</label>
    </p>
    <!-- 住所選択・フォーム -->
    <p>
        住所　
        都道府県　　　
        <select name="prefName">
            <option value="">選択してください</option>
            <option value="01">北海道</option>
            <option value="02">青森県</option>
            <option value="03">岩手県</option>
            <option value="04">宮城県</option>
            <option value="05">秋田県</option>
            <option value="06">山形県</option>
            <option value="07">福島県</option>
            <option value="08">茨城県</option>
            <option value="09">栃木県</option>
            <option value="10">群馬県</option>
            <option value="11">埼玉県</option>
            <option value="12">千葉県</option>
            <option value="13">東京都</option>
            <option value="14">神奈川県</option>
            <option value="15">新潟県</option>
            <option value="16">富山県</option>
            <option value="17">石川県</option>
            <option value="18">福井県</option>
            <option value="19">山梨県</option>
            <option value="20">長野県</option>
            <option value="21">岐阜県</option>
            <option value="22">静岡県</option>
            <option value="23">愛知県</option>
            <option value="24">三重県</option>
            <option value="25">滋賀県</option>
            <option value="26">京都府</option>
            <option value="27">大阪府</option>
            <option value="28">兵庫県</option>
            <option value="29">奈良県</option>
            <option value="30">和歌山県</option>
            <option value="31">鳥取県</option>
            <option value="32">島根県</option>
            <option value="33">岡山県</option>
            <option value="34">広島県</option>
            <option value="35">山口県</option>
            <option value="36">徳島県</option>
            <option value="37">香川県</option>
            <option value="38">愛媛県</option>
            <option value="39">高知県</option>
            <option value="40">福岡県</option>
            <option value="41">佐賀県</option>
            <option value="42">長崎県</option>
            <option value="43">熊本県</option>
            <option value="44">大分県</option>
            <option value="45">宮崎県</option>
            <option value="46">鹿児島県</option>
            <option value="47">沖縄県</option>
        </select>
        <br>
        　　　
        それ以降の住所
        <textarea name="address"></textarea>
    </p>
    <!-- パスワードフォーム -->
    <p>
        パスワード
        <input type="password" name="password">
    </p>
    <!-- パスワード確認フォーム -->
    <p>
        パスワード確認
        <input type="password" name="passwordConf">
    </p>
    <!-- メールアドレスフォーム -->
    <p>
        メールアドレス
        <input type="text" name="email">
    </p>
    <input type="submit" name="btnConfirm" value="確認画面へ">
</form>


