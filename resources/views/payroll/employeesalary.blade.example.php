@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}

@section('style')
<style>
    /* css for index.html */
    #list-member {
        width: 100%;
        padding: 30px;
        text-align: center;

        /* style for table */
        border-collapse: collapse;

        /* style for td */
        border: 1px solid #ccc;

        /* style for th */
        background-color: #0f7bb9;
        color: #fff;
    }

    #list-member td {
        padding: 10px;
    }


    table th {
        height: 50px;
    }

    body {
        background-color: #f2f2f2;
        font-family: Arial, Helvetica, sans-serif;
    }

    #close-dialog {
        position: absolute;
        top: 0;
        right: 0;
        font-size: 30px;
        cursor: pointer;
        padding: 10px;
    }


    #dialogAddF {
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        position: absolute;
        top: 0;
        left: 0;
        display: none;
        justify-content: center;
        align-items: center;
    }

    .dialog-content {
        width: 500px;
        height: 500px;
        background-color: #fff;
        border-radius: 10px;
        position: relative;
        margin: auto;
        /* margin top bottom center */
        padding: 20px;
        margin-top: 20%;
    }

    /* input */
    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    button {
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #4CAF50;
        color: #fff;
        cursor: pointer;

        /* center */
        display: block;
        margin: auto;

        /* width 30% */
        width: 100%;
    }

    #addF {
        width: 10%;
        height: 50px;
        float: right;

        margin: 10px 0 10px 0;
    }

    #dialogAddF table {
        width: 100%;
        padding: 30px;

    }

    #dialogAddF button {
        width: 50%;
        margin: auto;

    }
</style>
@endsection

<div>
    <h1>
        Các F của tôi
    </h1>

    <!-- button add F member -->
    <button id="addF" onclick="showAddFDialog()">Thêm F</button>
    <!-- show dialog add F with params is DSN -->
    <div id="dialogAddF" class="dialog">
        <div class="dialog-content">
            <span id="close-dialog" class="close">&times;</span>
            <table>
                <tr>
                    <td>Tên F</td>

                    <td>
                        <input type="text" name="name" id="name">
                    </td>
                </tr>
                <tr>
                    <td>Doanh số 1-1</td>
                    <td>
                        <input type="text" name="valueOneToOne" id="valueOneToOne">
                    </td>
                </tr>
                <tr>
                    <td>Doanh số cá nhân ilets</td>
                    <td>
                        <input type="text" name="valueIlets" id="valueIlets">
                    </td>
                </tr>
                <tr>
                    <td>Doanh số cá hệ thống</td>
                    <td>
                        <input type="text" name="valueSystem" id="valueSystem">
                    </td>
                </tr>
            </table>
            <!--  button add -->
            <button id="add" onclick="addNewF()">Thêm</button>
        </div>
    </div>

    <table id="list-member">
        <th>Name</th>
        <th>Doanh thu Ilets</th>
        <th>Doanh thu 1-1</th>
        <th>Doanh thu hệ thống</th>
        <th>Bậc</th>
    </table>

    <div id="caculate">
        <div>
            <table>
                <tr>
                    <td>
                        Họ và tên
                    </td>
                    <td>
                        <input type="text" name="name" id="myName">
                    </td>
                </tr>
                <tr>
                    <td>
                        DSCN Ilets
                    </td>
                    <td>
                        <input type="text" name="dscnIlets" id="myDscnIlets">
                    </td>
                </tr>
                <tr>
                    <td>
                        Doanh số Nhóm
                    </td>
                    <td>
                        <input type="text" name="mySystemValue" id="mySystemValue">
                    </td>
                </tr>
                <tr>
                    <td>
                        DSCN Doanh số 1-1
                    </td>
                    <td>
                        <input type="text" name="myOnetoOneValue" id="myOnetoOneValue">
                    </td>
                </tr>
                <tr>
                    <td>
                        Bậc
                    </td>
                    <td>
                        <h4 name="myPosition" id="myPosition">
                    </td>
                </tr>
                <tr>
                    <td>
                        salary
                    </td>
                    <td>
                        <h4 name="mySalary" id="mySalary">
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- /Page Wrapper -->
@section('script')
<script>
    const Position_Master = {
        level1: {
            level: 1,
            position: "Tư vấn viên cấp 1",
            raito: 0.18,
            min: 0,
            max: 80000000
        },
        level2: {
            level: 2,
            position: "Tư vấn viên cấp 2",
            raito: 0.2,
            min: 80000000,
            max: 400000000
        },
        level3: {
            level: 3,
            position: "Trưởng phòng",
            raito: 0.22,
            min: 400000000,
            max: 800000000
        },
        level4: {
            level: 4,
            position: "Giám đốc vùng",
            raito: 0.24,
            min: 800000000,
            max: 1600000000
        },
        level5: {
            level: 5,
            position: "Giám đốc kinh doanh cấp cao",
            raito: 0.26,
            min: 1600000000,
            max: 3200000000
        },
        level6: {
            level: 6,
            position: "Cổ đông chiến lược",
            raito: 0.28,
            min: 3200000000,
            max: 6400000000
        },
        level7: {
            level: 7,
            position: "CEO",
            raito: 0.29,
            min: 6400000000,
            max: Number.MAX_VALUE
        },
        level8: {
            level: 8,
            position: "Phó CT",
            raito: 0.29,
            min: 6400,
            max: Number.MAX_VALUE
        },
        level9: {
            level: 9,
            position: "Co-Founder",
            raito: 0.29,
            min: 6400,
            max: Number.MAX_VALUE
        },
    }

    const conditionOfValue = 50000000;

    class Member {
        constructor(name, valueOneToOne, valueIlets, valueOfSystem) {
            this.name = name;
            this.valueOneToOne = valueOneToOne;
            this.valueIlets = valueIlets;
            this.valueOfSystem = valueOfSystem
            this.title = "";
            this.current_position = null;
            this.setPosition();
        }

        setPosition() {
            switch (true) {
                case this.valueOfSystem > Position_Master.level1.min && this.valueOfSystem <= Position_Master.level1.max:
                    this.current_position = Position_Master.level1;
                    break;
                case this.valueOfSystem > Position_Master.level2.min && this.valueOfSystem <= Position_Master.level2.max:
                    this.current_position = Position_Master.level2;
                    break;
                case this.valueOfSystem > Position_Master.level3.min && this.valueOfSystem <= Position_Master.level3.max:
                    this.current_position = Position_Master.level3;
                    break;
                case this.valueOfSystem > Position_Master.level4.min && this.valueOfSystem <= Position_Master.level4.max:
                    this.current_position = Position_Master.level4;
                    break;
                case this.valueOfSystem > Position_Master.level5.min && this.valueOfSystem <= Position_Master.level5.max:
                    this.current_position = Position_Master.level5;
                    break;
                case this.valueOfSystem > Position_Master.level6.min && this.valueOfSystem <= Position_Master.level6.max:
                    this.current_position = Position_Master.level6;
                    break;
                case this.valueOfSystem > Position_Master.level7.min && this.valueOfSystem <= Position_Master.level7.max:
                    this.current_position = Position_Master.level7;
                    break;
                case this.valueOfSystem > Position_Master.level8.min && this.valueOfSystem <= Position_Master.level8.max:
                    this.current_position = Position_Master.level8;
                    break;
                case this.valueOfSystem > Position_Master.level9.min && this.valueOfSystem <= Position_Master.level9.max:
                    this.current_position = Position_Master.level9;
                    break;
            }

            // check from lv > 3
            if (this.current_position && this.current_position.level >= 3) {
                // check value of ilets
                if (this.valueIlets > conditionOfValue) {
                    this.title = this.current_position.position;
                } else {
                    if (this.valueIlets + this.valueOneToOne < conditionOfValue) {
                        // title = current level - 1
                        this.title = Position_Master[`level${this.current_position.level - 1}`].position;
                        this.current_position = Position_Master[`level${this.current_position.level - 1}`];
                    }
                }
            } else {
                this.title = this.current_position.position;
            }

            return this.current_position;
        }
    }

    const listF = [];
    listF.push(new Member("Lê Thành Quý", 38506000, 38506000, 38506000))
    listF.push(new Member("Đỗ Thị Thanh An", 33436000, 33436000, 33436000))


    const showAddFDialog = () => {
        // show dialog addF
        document.getElementById("dialogAddF").style.display = "block";

        document.getElementById("close-dialog").addEventListener("click", () => {
            document.getElementById("dialogAddF").style.display = "none";
        })
    }

    const showListF = () => {
        for (const f of listF) {
            const table = document.getElementById("list-member");
            const row = table.insertRow(1);
            row.insertCell(0).innerHTML = f.name;
            row.insertCell(1).innerHTML = f.valueOneToOne.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            row.insertCell(2).innerHTML = f.valueIlets.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            row.insertCell(3).innerHTML = f.valueOfSystem.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            row.insertCell(4).innerHTML = f.title;
        }
    }

    showListF()

    // add new F
    const addNewF = () => {
        const name = document.getElementById("name").value;
        const valueOneToOne = document.getElementById("valueOneToOne").value;
        const valueIlets = document.getElementById("valueIlets").value;
        const valueSystem = document.getElementById("valueSystem").value;

        const f = new Member(name, Number(valueOneToOne.replaceAll(",", "")), Number(valueIlets.replaceAll(",", "")), Number(valueSystem.replaceAll(",", "")));
        listF.push(f);
        document.getElementById("dialogAddF").style.display = "none";

        // add to display table member f
        const table = document.getElementById("list-member");
        const row = table.insertRow(1);
        row.insertCell(0).innerHTML = f.name;
        row.insertCell(1).innerHTML = f.valueOneToOne.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        row.insertCell(2).innerHTML = f.valueIlets.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        row.insertCell(3).innerHTML = f.valueOfSystem.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        row.insertCell(4).innerHTML = f.title;
    }

    const myName = document.getElementById("myName");
    const dscnIlets = document.getElementById("myDscnIlets");
    const mySystemValue = document.getElementById("mySystemValue");
    const myOnetoOneValue = document.getElementById("myOnetoOneValue");

    const detectPosition = () => {
        // dscnIlets onchange => detect position
        const dscnIletsValue = Number(dscnIlets.value.replaceAll(",", ""));
        const valueOfSystem = Number(mySystemValue.value.replaceAll(",", ""));
        const valueOneToOne = Number(myOnetoOneValue.value.replaceAll(",", ""));


        if (dscnIletsValue && valueOfSystem && valueOneToOne) {
            const myPosition = new Member(myName.value, valueOneToOne, dscnIletsValue, valueOfSystem);
            // show position onchange value


            if (myPosition.current_position.level == 8) {
                // role PCT check xem có nhánh CEO không trong listF
                const isCEO = listF.find(f => f.title == "CEO");
                if (!isCEO) {
                    // hạ lv8 xuống 7
                    myPosition.current_position = Position_Master.level7;
                }
            } else if (myPosition.current_position.level == 9) {
                // role PCT check xem có nhánh 3 CEO không trong listF
                const isCEO = listF.filter(f => f.title == "CEO");
                if (isCEO.length < 3) {
                    // hạ lv9 xuống 8
                    myPosition.current_position = Position_Master.level8;
                    if (myPosition.current_position.level == 8) {
                        // role PCT check xem có nhánh CEO không trong listF
                        const isCEO = listF.find(f => f.title == "CEO");
                        if (!isCEO) {
                            // hạ lv8 xuống 7
                            myPosition.current_position = Position_Master.level7;
                        }
                    }
                }
            }

            const myPositionNode = document.getElementById("myPosition");
            myPositionNode.textContent = myPosition.title;


            // compute salary
            const salary = document.getElementById("mySalary");
            computeSalary(myPosition, salary);
        }
    }

    const computeSalary = (myPosition, salary) => {
        switch (true) {
            case myPosition.current_position.level < 8:
                let totalSalaryFromF = 0;
                console.log(myPosition)

                // salary of me from listF = sum((myPosition.current_position.raito-raito of F)DSCN Ilets of F in listF)
                for (const f of listF) {
                    console.log(f)
                    const salaryFromF = (myPosition.current_position.raito - f.current_position.raito) * f.valueIlets;
                    totalSalaryFromF += salaryFromF;
                }

                salary.textContent = (totalSalaryFromF + myPosition.current_position.raito * myPosition.valueIlets).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");;
                break;
            case 8:
                salary.textContent = "4.500.000";
                break;
            case 9:
                salary.textContent = "5.000.000";
                break;
            default:
                salary.textContent = "0";
                break;
        }
    }

    myName.addEventListener("change", () => {
        detectPosition();
    });

    dscnIlets.addEventListener("change", () => {
        detectPosition();
    });

    mySystemValue.addEventListener("change", () => {
        detectPosition();
    });

    myOnetoOneValue.addEventListener("change", () => {
        detectPosition();
    });
</script>
@endsection
@endsection