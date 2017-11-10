import express from 'express'
import bodyParser from 'body-parser'
import cookieParser from 'cookie-parser'
// import ht from 'hudson-taylor'
import cors from 'cors'
import path from 'path'

import { connectDB, connectpg } from '../middleware/auth'
import { getSummonerName, getUserChampionMastery } from '../actions/riot'

const config = require(path.resolve(__dirname, '../config', process.env.NODE_ENV || 'development'))

// Export a function that takes callback
// If a callback is passed when this function is called
// express won't start listening on a port. If it's not passed
// it will start listening and bind to whatever is specified in config
export default async function () {
//   // Fetch our config file
//   let config, log, rollbar
//   try {
//     const context = await bootstrapper()
//     config = context.config
//     log = context.logger
//     rollbar = context.rollbar
//   } catch (error) {
//     log.critical('Failed to load application configuration! ', error)
//     throw error
//   }

  // Create our express app, add JSON body support
  // and disable the x-powered-by header
  const app = express()
  app.use(cors({
    origin: config.cors.allowedOrigins,
    credentials: true
  }))
  app.use(bodyParser.json())
  app.use(cookieParser())

  app.disable('x-powered-by')

  // Create a new HT service
  // This is how our consumers will communicate with us.
//   const service = new ht.Service(new ht.Transports.HTTP({ app, path: '/personalization' }))

//   // Lets create a client we can use to interact with other services.
//   const client = new ht.Client({
//     accounts: new ht.Transports.HTTP({ host: config.accountService.host, port: config.accountService.port })
//   })

  // Here we register our express app routes
//   initializeAppRoutes(app, service, client, config, log)

  // Here we mount our HT service methods
//   initializeHTServices(service, config, log)

  // Define a generic ping function
  // This should be changed to provide
  // business-logic specific uptime tests
  app.get('/ping', (req, res) => {
    console.log('PONG!', config)
    return res.status(200).json('OK. PONG!')
  })

  app.get('/users', async (req, res) => {
    console.log('Queryin!!!!')
    const copg = await connectpg()
    // console.log(copg)
    return res.status(200).json(copg)
  })

  app.get('/summoner/:name/:region', async (req, res) => {
    const summonerName = req.params.name
    const region = req.params.region
    console.log('Queryin Summoner Name')
    const summoner = await getSummonerName(summonerName, region)
    // console.log(summoner)
    return res.status(200).json(summoner)
  })

  app.get('/championmastery/:summonerId/:region', async (req, res) => {
    const summonerId = req.params.summonerId
    const region = req.params.region
    console.log('Queryin Summoner Id for Champ Mastery')
    const championMastery = await getUserChampionMastery(summonerId, region)
    // console.log(championMastery)
    return res.status(200).json(championMastery)
  })

  // Add a catchall handler, for 404
  app.all('*', (req, res) => {
    return res.sendStatus(404)
  })

  // Start listening!
  const server = app.listen(config.app.port, config.app.host, (err) => {
    if (err) {
      throw err
    }
    console.log(`Server listening on ${config.app.host}:${config.app.port}`)
  })

  process.on('unhandledRejection', (reason, p) => {
    console.log('Unhandled Rejection at: Promise', p, 'reason:', reason)
    // application specific logging, throwing an error, or other logic here
  })

  // for testing
  return { server }
}

// function initializeAppRoutes (app, service, client, config, log) {
//   const auth = authService(config, client, log)
//   genreRoutes(app, service, config, log)
//   splitRoutes(app, auth, service, config, log)
//   userProfileRoutes(app, auth, service, config, log)
//   tagsRoutes(app, auth, service, config, log)
// }

// function initializeHTServices (service, config, log) {
//   genreService(service, config, log)
//   splitService(service, config, log)
//   userProfileService(service, config, log)
//   tagsService(service, config, log)
// }
