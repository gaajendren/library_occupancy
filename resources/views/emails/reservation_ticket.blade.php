<!DOCTYPE html>
<html>
<head>
    <title>Reservation Ticket</title>
</head>
<body>
    <h1>Your Reservation is Confirmed!</h1>
    <p>Dear {{ $reservation->get_student->name }},</p>
    <p>Thank you for reserving. Here are your details:</p>
    <ul>
        <li>Reservation ID: {{ $reservation->ticket_no }}</li>
        <li>Date: {{ $reservation->date }}</li>
        <li>Room: {{ $reservation->get_room->name }}</li>
    </ul>
    <p>We look forward to seeing you!</p>
</body>
</html>
