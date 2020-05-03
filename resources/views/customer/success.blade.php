<style media="screen">
    #alert {
        background: #f8d7da;
        padding: 5px 10px;
        border-radius: 8px;
    }
    .animation-ctn{
        text-align:center;
        margin: 5em auto;
    }

    @-webkit-keyframes checkmark {
        0% {
            stroke-dashoffset: 100px
        }

        100% {
            stroke-dashoffset: 200px
        }
    }

    @-ms-keyframes checkmark {
        0% {
            stroke-dashoffset: 100px
        }

        100% {
            stroke-dashoffset: 200px
        }
    }

    @keyframes checkmark {
        0% {
            stroke-dashoffset: 100px
        }

        100% {
            stroke-dashoffset: 0px
        }
    }

    @-webkit-keyframes checkmark-circle {
        0% {
            stroke-dashoffset: 480px

        }

        100% {
            stroke-dashoffset: 960px;

        }
    }

    @-ms-keyframes checkmark-circle {
        0% {
            stroke-dashoffset: 240px
        }

        100% {
            stroke-dashoffset: 480px
        }
    }

    @keyframes checkmark-circle {
        0% {
            stroke-dashoffset: 480px
        }

        100% {
            stroke-dashoffset: 960px
        }
    }

    @keyframes colored-circle {
        0% {
            opacity:0
        }

        100% {
            opacity:100
        }
    }

    /* other styles */
    /* .svg svg {
    display: none
    }
    */
    .inlinesvg .svg svg {
        display: inline
    }

    /* .svg img {
    display: none
    } */

    .icon--order-success svg polyline {
        -webkit-animation: checkmark 0.3s ease-in-out 0.9s backwards;
        animation: checkmark 0.3s ease-in-out 0.9s backwards
    }

    .icon--order-success svg circle {
        -webkit-animation: checkmark-circle 0.6s ease-in-out backwards;
        animation: checkmark-circle 0.6s ease-in-out backwards;
    }
    .icon--order-success svg circle#colored {
        -webkit-animation: colored-circle 0.6s ease-in-out 0.7s backwards;
        animation: colored-circle 0.6s ease-in-out 0.7s backwards;
    }
</style>
<title> Payment Success </title>
<div class="animation-ctn">
    @if(isset($payment))
        <div class="icon icon--order-success svg">
            <svg xmlns="http://www.w3.org/2000/svg" width="154px" height="154px">
                <g fill="none" stroke="#22AE73" stroke-width="2">
                    <circle cx="77" cy="77" r="72" style="stroke-dasharray:480px, 480px; stroke-dashoffset: 960px;"></circle>
                    <circle id="colored" fill="#22AE73" cx="77" cy="77" r="72" style="stroke-dasharray:480px, 480px; stroke-dashoffset: 960px;"></circle>
                    <polyline class="st0" stroke="#fff" stroke-width="10" points="43.5,77.8 63.7,97.9 112.2,49.4 " style="stroke-dasharray:100px, 100px; stroke-dashoffset: 200px;"/>
                </g>
            </svg>
        </div>
        <br />
        <h2>Payment Success</h2>
        <p>Payment Id: {{ $payment->payment_id }}</p>
        <p>Amount: {{ $payment->payment_total }} ฿</p>
        <p>Status: {{ $payment->payment_status }} </p>
        <p>Payment Id in paypal: {{ $payment->reference_id }} </p>
        <p>Payment Date: {{ $payment->payment_date }} </p>
    @else
        <div class="icon icon--order-success svg">
            <svg xmlns="http://www.w3.org/2000/svg" width="154px" height="154px">
                <g fill="none" stroke="#FF0000" stroke-width="2">
                    <circle cx="77" cy="77" r="72" style="stroke-dasharray:480px, 480px; stroke-dashoffset: 960px;"></circle>
                    <circle id="colored" fill="#FF0000" cx="77" cy="77" r="72" style="stroke-dasharray:480px, 480px; stroke-dashoffset: 960px;"></circle>
                    <line x1="35" x2="120" y1="80" y2="80" stroke="white" stroke-width="12" stroke-linecap="square"></line>
            </svg>
        </div>
        <h2>Payment Fail</h2>
        <br />
    @endif
        <span id="alert">
            <b><a href="{{ URL('home') }}" style="text-decoration: none; color: black"> Back To Home</a></b>
        </span>
</div>
