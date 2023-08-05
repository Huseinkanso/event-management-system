<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Event;
use App\Models\Payment;
use App\Notifications\TicketPurchased;
use App\Providers\TicketSold;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Transfer;

class PaymentController extends Controller
{

    public function index()
    {
        // dd(auth()->user());
        return PaymentResource::collection(auth()->user()->payments);
    }

    public function pay(Request $request, Event $event)
    {
        // $request->paymentMethod['id']
        // $request->ticket_count
        // Set the Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Calculate the ticket price and fee amount
        $speaker = $event->speaker;
        $ticketPrice = $event->ticket_price * $request->ticket_count; // Example ticket price
        $feePercentage = 10; // Example fee percentage (10%)
        $feeAmount = $ticketPrice * $feePercentage / 100;
        $amountAfterFee = $ticketPrice - $feeAmount;

        try {
            // Create a PaymentIntent
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $ticketPrice * 100,
                'currency' => 'usd',
                'payment_method' => $request->paymentMethod['id'],
                'confirm' => true,
                'description' => 'Ticket purchase'
            ]);
            // payment intent must be confirmed and then get payment method id attribute
            // $paymentIntent->confirm();
            // $paymentMethodId = $paymentIntent->payment_method;
            // Create a charge for the ticket purchase
            $charge = Charge::create([
                'amount' => $ticketPrice * 100, // amount in cents
                'currency' => 'usd',
                'source' => $paymentIntent->id,
                'description' => 'Ticket purchase',
            ]);
            // Transfer ticket amount to speaker's account
            $transfer = Transfer::create([
                'amount' => $amountAfterFee * 100, // amount in cents
                'currency' => 'usd',
                'source_transaction' => $charge->id,
                'destination' => $speaker->stripe_account_id,
            ]);

            // Transfer fee amount to website's account
            $transfer = Transfer::create([
                'amount' => $feeAmount * 100, // amount in cents
                'currency' => 'usd',
                'source_transaction' => $charge->id,
                'destination' => env('STRIPE_PLATFORM_ACC_ID'), // authenticated account id
            ]);

            DB::beginTransaction();
            try {
                $event->tickets()->create([
                    'user_id' => auth()->user()->id,
                    'ticket_count' => $request->ticket_count,
                    'event_id' => $event->id
                ]);
                $event->update([
                    'ticket_remaining' => $event->ticket_remaining - $request->ticket_count
                ]);
                // like this code we add dynamically product id and product type using morph many to many
                $event->payments()->save(new Payment([
                    'payment_id' => $charge->id,
                    'amount' => $ticketPrice,
                    'user_id' => auth()->user()->id
                ]));
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return response(['error' => $th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR]);
            }
            return response(['notify', 'ticket purchased succesfully you will get an email with the ticket information']);
        } catch (\Throwable $th) {
            throw $th;
            return response(['error' => $th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }
}


/*
//// doing single charge using stripe-cachier with event
 1- store amount,user,payment details,number of tickets
        a)create event_tickets
        user_id,event-id,ticket_count
        b) create payment
        user_id,event_id,payment_id
        2- create payment
        3-change ticket remaining

        set the amount
        $amount = $event->ticket_price * $request->ticket_count;
        execute the payment
        $paymentDeltails = auth()->user()->charge($amount, $request->paymentMethod['id'], [
        'description' => 'payment for ' . $event->slug,
        ]);

        trigger the event
        event(new TicketSold($event, $request->ticket_count, $amount, $request->paymentMethod['id']));

        auth()->user()->notify(new TicketPurchased());
        $event->update([
            'ticket_remaining'=>$event->ticket_remaining - $request->ticket_count
        ]);

        $event->tickets()->create([
            'user_id'=>auth()->user()->id,
            'ticket_count'=>$request->ticket_count,
            'event_id'=> $event->id
        ]);

        // like this code we add dynamically product id and product type using morph many to many
        $event->payments()->save(new Payment([
            'payment_id'=>$paymentDeltails->id,
            'amount'=>$amount,
            'user_id'=>auth()->user()->id
        ]));

        instead of doing all that we can create a laravel event that will listen to event and execute all the work when it happen
        we will make an event and a listener and put them in eventserviceprovider
        1- making event and listener
        we can register event and listener and run php artisan event:generate (this will create the registered events if its not created)
        in eventprovider
        OrderShipped::class => [
            SendShipmentNotification::class,
        ],
        or create event by make:event and listenere by make:listener and register after
*/