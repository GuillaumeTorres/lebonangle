let express = require('express')
let router = express.Router()
let Booking = require('../db/db').Booking

/**
 * @api {post} /book/search Search
 * @apiName search
 * @apiGroup Booking
 *
 * @apiParam {String} city City
 * @apiParam {Number} place_number Number of place available
 * @apiParam {Date} date_departure Date of departure
 * @apiParam {Date} date_arrival Date of arrival
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     [
         {
             "_id": "59e07ba97635dd6885be8aae",
             "reserved": true,
             "date": {
                 "departure": "2017-11-01T09:00:00.000Z",
                 "arrival": "2017-11-10T09:00:00.000Z"
             },
             "house": {
                 "title": "ma maison",
                 "description": "C MA MAISON GUEUH",
                 "place_number": 4,
                 "address": {
                     "street": "la rue",
                     "city": "Paris",
                     "postal_code": "92"
                 }
             },
             "user": "59e0bbff4bb62e04db95e30d"
         }
       ]
 */
router.post('/search', (req, res) => {
    const parameters = req.body
    const dateDeparture = new Date(parameters.date_departure)
    const dateArrival = new Date(parameters.date_arrival)
        Booking.find({
            'house.address.city': parameters.city,
            'house.place_number': parameters.place_number,
            'reserved': false,
            'date.departure': {$gte: (dateDeparture)},
            'date.arrival': {$lte: dateArrival}
        })
        .then(book => res.send(book))
        .catch(err => res.status(400).send(err.message || 500))
})

/**
 * @api {post} /book/create Create reservation
 * @apiName createReservation
 * @apiGroup Booking
 *
 * @apiParam {Object} house House get in the db
 * @apiParam {String} house.title Title
 * @apiParam {String} house.description Description
 * @apiParam {Number} house.place_number Number of available places
 * @apiParam {Object} house.address Address
 * @apiParam {String} house.address.city City
 * @apiParam {String} house.address.street Street information
 * @apiParam {Number} house.address.postal_code Postal code
 * @apiParam {Object} date Date information
 * @apiParam {Date} date.departure Date of departure
 * @apiParam {Date} date.arrival Date of arrival
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
         "_id": "59e07ba97635dd6885be8aae",
         "reserved": false,
         "date": {
             "departure": "2017-11-01T09:00:00.000Z",
             "arrival": "2017-11-10T09:00:00.000Z"
         },
         "house": {
             "title": "ma maison",
             "description": "C MA MAISON GUEUH",
             "place_number": 4,
             "address": {
                 "street": "la rue",
                 "city": "Paris",
                 "postal_code": "92"
             }
         },
         "user": null
        }
 */
router.post('/create', (req, res) => {
    const bookData = new Booking(req.body)

    bookData.save()
        .then(res.send(bookData))
        .catch(err => res.status(400).send(err.message || 500))
})

/**
 * @api {put} /book/edit/:id Edit house
 * @apiName editBooking
 * @apiGroup Booking
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
         "_id": "59e07ba97635dd6885be8aae",
         "reserved": false,
         "date": {
             "departure": "2017-11-01T09:00:00.000Z",
             "arrival": "2017-11-10T09:00:00.000Z"
         },
         "house": {
             "title": "ma maison",
             "description": "C MA MAISON GUEUH",
             "place_number": 4,
             "address": {
                 "street": "la rue",
                 "city": "Paris",
                 "postal_code": "92"
             }
         },
         "user": null
        }
 */
router.put('/edit/:id', (req, res) => {
    Booking.findOneAndUpdate(req.params.id, req.body)
        .then(booking => res.send(booking))
        .catch(err => res.status(404).send(err.message || 500))
})

/**
 * @api {post} /book/reserve Reserve
 * @apiName userReservation
 * @apiGroup Booking
 *
 * @apiParam {Number} id_book Id of booking
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
            success: "reservation valided"
       }
 */
router.post('/reserve', (req, res) => {
    const booking = {
        user: req.user._id,
        reserved: true
    }
    Booking.findOneAndUpdate({_id: req.body.id_book}, booking)
        .then(res.send({success: 'reservation valided'}))
        .catch(err => res.status(400).send(err.message || 500))
})

/**
 * @api {post} /book/cancel Cancel reservation
 * @apiName cancelReservation
 * @apiGroup Booking
 *
 * @apiParam {Number} id_book Id of booking
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
            success: "reservation canceled"
       }
 */
router.post('/cancel', (req, res) => {
    const booking = {
        user: null,
        reserved: false
    }
    Booking.findOneAndUpdate({_id: req.body.id_book}, booking)
        .then(res.send({success: 'reservation canceled'}))
        .catch(err => res.status(400).send(err.message || 500))
})

module.exports = router;