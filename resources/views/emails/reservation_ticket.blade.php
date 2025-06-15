
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation Ticket</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .ticket-container {
            max-width: 600px;
            background-color: #ffffff;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #1a73e8;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background-color: #f0f4ff;
            margin: 8px 0;
            padding: 12px 16px;
            border-left: 5px solid #1a73e8;
            border-radius: 6px;
            font-weight: 500;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <h1>Reservation Confirmed!</h1>
        <p>Dear {{ $reservation->get_student->name }},</p>
        <p>Thank you for reserving a room. Below are your reservation details:</p>
        <ul>
          <li>Reservation ID: {{ $reservation->ticket_no }}</li>
        <li>Date: {{ $reservation->date }}</li>
        <li>Room: {{ $reservation->get_room->name }}</li>
        </ul>
        <p class="footer">We look forward to seeing you on your reserved date.</p>
    </div>
</body>
</html>
