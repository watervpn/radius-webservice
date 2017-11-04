<?php
namespace Lib\Openvpn\Entity;

use Lib\Base\AbstractEntity;

class ServerStatus extends AbstractEntity
{
    protected $host;
    protected $region;
    protected $city;
    protected $totalUsers;
    protected $download;
    protected $upload;
    protected $downloadAvail;
    protected $uploadAvail;
    protected $cpu;
    protected $mem;
    protected $eth;
    protected $info;
    protected $modified;

    public function __construct($host = null, $region= null, $city= null, $totalUsers= null, $download= null, $upload= null, $downloadAvail=null, $uploadAvail=null, $cpu =null, $mem=null, $eth=null, $info=array(), $modified = null)
    {
        $this->host             = $host;
        $this->region           = $region;
        $this->city             = $city;
        $this->totalUsers       = $totalUsers;
        $this->download         = $download;
        $this->upload           = $upload;
        $this->downloadAvail    = $downloadAvail;
        $this->uploadAvail      = $uploadAvail;
        $this->cpu              = $cpu;
        $this->mem              = $mem;
        $this->eth              = $eth;
        $this->info             = $info;
        $this->modified         = $modified;
    }

    public function addInfo($key, $value)
    {
        $info = $this->getInfo();
        $info[$key] = $value;
        $this->setInfo($info);
    }

    public function removeInfo($key)
    {
        $info = $this->getInfo();
        unset($info[$key]);
        $this->setInfo($info);
    }

    // Getter
    public function getHost()
    {
        return $this->host;
    }
    public function getRegion()
    {
        return $this->region;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function getTotalUsers()
    {
        return $this->totalUsers;
    }
    public function getDownload()
    {
        return $this->download;
    }
    public function getUpload()
    {
        return $this->upload;
    }
    public function getDownloadAvail()
    {
        return $this->downloadAvail;
    }
    public function getUploadAvail()
    {
        return $this->uploadAvail;
    }
    public function getCpu()
    {
        return $this->cpu;
    }
    public function getMem()
    {
        return $this->mem;
    }
    public function getEth()
    {
        return $this->eth;
    }
    /**
     * return array
     */
    public function getInfo()
    {
        return json_decode($this->info, true);
    }
    public function getInfoByKey($key)
    {
        $info = $this->getInfo();
        return $info[$key];
    }
    public function getModified()
    {
        return $this->modified;
    }

    // Setter
    public function setHost($host)
    {
        $this->host = $host;
    }
    public function setRegion($region)
    {
        $this->region = $region;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }
    public function setTotalUsers($totalUsers)
    {
        $this->totalUsers = (int)$totalUsers;
    }
    public function setDownload($download)
    {
        $this->download = $download;
    }
    public function setUpload($upload)
    {
        $this->upload = $upload;
    }
    public function setDownloadAvail($downloadAvail)
    {
        $this->downloadAvail = $downloadAvail;
    }
    public function setUploadAvail($uploadAvail)
    {
        $this->uploadAvail = $uploadAvail;
    }
    public function setCpu($cpu)
    {
        $this->cpu = $cpu;
    }
    public function setMem($mem)
    {
        $this->mem = $mem;
    }
    public function setEth($eth)
    {
        $this->eth = $eth;
    }
    public function setInfo(array $info)
    {
        $this->info = json_encode($info, true);
    }
    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    /**
     * Implement Abstract exchangearray
     */
    public function exchangeArray(array $data)
    {
        $this->host             = (!empty($data['host'])) ? $data['host'] : null; 
        $this->region           = (!empty($data['region'])) ? $data['region'] : null;
        $this->city             = (!empty($data['city'])) ? $data['city'] : null;
        $this->totalUsers       = (!empty($data['total_users'])) ? $data['total_users'] : null;
        $this->download         = (!empty($data['download'])) ? $data['download'] : null;
        $this->upload           = (!empty($data['upload'])) ? $data['upload'] : null;
        $this->downloadAvail    = (!empty($data['download_avail'])) ? $data['download_avail'] : null;
        $this->uploadAvail      = (!empty($data['upload_avail'])) ? $data['upload_avail'] : null;
        $this->cpu              = (!empty($data['cpu'])) ? $data['cpu'] : null;
        $this->mem              = (!empty($data['mem'])) ? $data['mem'] : null;
        $this->eth              = (!empty($data['eth'])) ? $data['eth'] : null;
        $this->info             = (!empty($data['info'])) ? $data['info'] : null;
        $this->modified         = (!empty($data['modified'])) ? $data['modified'] : null;
    }

    /**
     * Implement Abstract getarraycopy
     */
    public function getArrayCopy()
    {
        return array(
            'host'         => $this->host,
            'region'         => $this->region,
            'city'           => $this->city,
            'total_users'    => $this->totalUsers,
            'download'       => $this->download,
            'upload'         => $this->upload,
            'download_avail' => $this->downloadAvail,
            'upload_avail'   => $this->uploadAvail,
            'cpu'            => $this->cpu,
            'mem'            => $this->mem,
            'eth'            => $this->eth,
            'info'           => $this->info,
            'modified'       => $this->modified,
        );
    }

}
