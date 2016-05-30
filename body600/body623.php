<h1 align="center">상품입력</h1>

<form action="../Ctl/MainCTL.php?action=624" method="post" enctype="multipart/form-data">
<table align="center">
    <tr>
        <td>카테고리</td>
        <td>
            <select name="pcategory">
                <option value="C1" selected>반팔-C1</option>
                <option value="C2">긴팔-C2</option>
                <option value="C3">니트-C3</option>
                <option value="B1">5부(바지)-B1</option>
                <option value="B2">팬츠(바지)-B2</option>
                <option value="B3">스키니(바지)-B3</option>
                <option value="H1">비니(모자)-P1</option>
                <option value="H2">캡(모자)-P2</option>
                <option value="S1">나이키(신발)-S1</option>
                <option value="S2">아디다스(신발)-S2</option>
                <option value="G1">털장갑-G1</option>
                <option value="G2">가죽장갑-G2</option>
                <option value="G3">반장갑-G3</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>상품이름</td><td><input type="text" size="20" name="pname"></td>
    </tr>
    <tr>
        <td>제고량</td><td><input type="text" size="20" name="pstock"></td>
    </tr>
    <tr>
        <td>가격</td><td><input type="text" size="20" name="pprice"></td>
    </tr>
    <tr>
        <td></td><td><input type="file" name="pfimage"></td>
    </tr>
        <tr><td colspan="2" align="right"><input type="submit" value="입력완료"></td></tr>
</table>
</form>
