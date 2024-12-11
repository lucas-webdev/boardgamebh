import FtpDeploy from 'ftp-deploy';
import dotenv from 'dotenv';
dotenv.config();

const ftpDeploy = new FtpDeploy();

const config = {
  user: process.env.FTP_USER,
  password: process.env.FTP_PASSWORD,
  host: process.env.FTP_HOST,
  port: 21,
  localRoot: __dirname + '/dist',
  remoteRoot: '/public_html/',
  include: ['*', '**/*'],
  deleteRemote: true,
};

ftpDeploy
  .deploy(config)
  .then(() => console.log('Deploy realizado com sucesso!'))
  .catch((err) => console.error('Erro no deploy:', err));
