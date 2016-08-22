# WaPoNe_StatusStaticBlocksManager
A Magento extension to schedule CMS blocks enabling/disabling

##Installation

1. Login into the backend, go to System — Cache Management and enable all types of cache.
2. Go to System — Tools — Compilation and make sure compilation is disabled.
3. Connect to your website source folder with FTP/SFTP/SSH and upload all the extension files and folders from “Step1” folder of the extension package to the root folder of your Magento installation.
Please use the “Merge” upload mode. Do not replace the whole folders, but merge them. This way your FTP/SFTP client will only add new files. This mode is used by default by most of FTP/SFTP clients software. For MacOS it’s recommended to use Transmit. If you install several extensions from Amasty, they will contain same files from the Base package — feel free to overwrite them, these are system files used by all our extensions.
4. Upload all the extension files and folders from “Step2” folder the same way you did in the previous step.
5. Go to System — Cache Management page under Magento backend and click “Flush Cache Storage” button. After this action, the extension is installed.
6. If you need to enable compilation, you can do it now at System — Tools — Compilation.
7. Please log out of the backend and log in again, so Magento can refresh permissions.
