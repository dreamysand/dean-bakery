<?php
date_default_timezone_set("Asia/Jakarta");
/**
 * 
 */
class Image
{
	function ImageUpload($file, $location, $url)
	{
		if (isset($file)) {
			if ($file['error'] == 0) {
				$allowed_Ext = [
					'jpg',
					'png',
					'jpeg',
					'gif',
					'jfif',
					'webp',
					'svg'
				];
				$target_Dir = $location;
				$img_Ext_Info = new SplFileInfo($file['name']);
				$img_Ext = $img_Ext_Info->getExtension();
				$new_File_Name = uniqid().".$img_Ext";
				$target_File = $target_Dir . $new_File_Name;
				$image_URL = $url . $new_File_Name;

				if (in_array($img_Ext, $allowed_Ext)) {
					if (move_uploaded_file($file['tmp_name'], $target_File)) {
						$img_Path = $target_File;
						$img_URL = $image_URL;
						$image_Array = [
							"url" => $img_URL,
							"path" => $img_Path
						];
						return $image_Array;
					} else {
						?>
						<script>
							console.log('Gambar gagal diupload');
						</script>
						<?php
						return null;
					}
				} else {
					?>
					<script>
						console.log('Ekstensi tidak didukung');
					</script>
					<?php
					return null;
				}
			}
		}
	}

	function ImagesUpload($file, $location)
	{
		$images = [];
		foreach ($file['name'] as $index => $name) {
			if (isset($file)) {
				if ($file['error'][$index] == 0) {
					$allowed_Ext = [
						'jpg',
						'png',
						'jpeg',
						'gif',
						'jfif',
						'webp',
						'svg'
					];
					$target_Dir = $location;
					$img_Ext_Info = new SplFileInfo($name);
					$img_Ext = $img_Ext_Info->getExtension();
					$new_File_Name = uniqid().".$img_Ext";
					$target_File = $target_Dir . $new_File_Name;

					if (in_array($img_Ext, $allowed_Ext)) {
						if (move_uploaded_file($file['tmp_name'][$index], $target_File)) {
							$images[] = $target_File;
						} else {
							?>
							<script>
								console.log('Gambar gagal diupload');
							</script>
							<?php 
						}
					} else {
						?>
						<script>
							console.log('Ekstensi tidak didukung');
						</script>
						<?php			
					}
				}
			}		
		}
		return $images;
	}

	function UpdateImage($file, $location, $url, $path_Image_Old, $URL_Image_Old)
	{
		$image_Array = [];
		if (empty($file['name'])) {
			$image_Array = [
				"url" => $URL_Image_Old,
				"path" => $path_Image_Old
			];
			return $image_Array;
		}

		if (file_exists($path_Image_Old)) {
			if (unlink($path_Image_Old)) {
				if ($file['error'] == 0) {
					$allowed_Ext = [
						'jpg',
						'png',
						'jpeg',
						'gif',
						'jfif',
						'webp',
						'svg'
					];
					$target_Dir = $location;
					$img_Ext_Info = new SplFileInfo($file['name']);
					$img_Ext = $img_Ext_Info->getExtension();
					$new_File_Name = uniqid().".$img_Ext";
					$target_File = $target_Dir . $new_File_Name;
					$image_URL = $url . $new_File_Name;

					if (in_array($img_Ext, $allowed_Ext)) {
						if (move_uploaded_file($file['tmp_name'], $target_File)) {
							$img_Path = $target_File;
							$img_URL = $image_URL;
							$image_Array = [
								"url" => $img_URL,
								"path" => $img_Path
							];
							return $image_Array;
						} else {
							return null;
						}
					} else {
						return null;
					}
				}
			} else {
				return null;
			}
		} else {
			return null;
		}
	}

	function DeleteImage($image)
	{
		if (file_exists($image)) {
			if (unlink($image)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
/**
 * 
 */
class Account
{
	private $id;
	private $email;
	private $username;
	private $password;
	private $gambar;

	function __construct($id = null, $email = null, $username = null, $password = null, $gambar = null)
	{
		$this->id = $id;
		$this->email = $email;
		$this->username = $username;
		$this->password = $password;
		$this->gambar = $gambar;
	}

	function CheckEmail($email)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE email = :email";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":email" => $email
		])) {
			if ($column = $stmt->fetchColumn()) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function CheckAdminDuplication($email)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE email = :email";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":email" => $email
		])) {
			if ($column = $stmt->fetchColumn()) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function CheckAdminDuplicationUpdate($email, $id_Admin)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE email = :email
		AND id != :id_admin";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":email" => $email,
			":id_admin" => $id_Admin
		])) {
			if ($column = $stmt->fetchColumn()) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function SelectAccount($email)
	{
		global $config, $table;
		$sql_Select_Query = "SELECT *
		FROM $table
		WHERE email = :email";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":email" => $email
		])) {
			if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function AddAdmin($email, $username, $password, $gambar)
	{
		global $config, $table;
		$sql_Add_Query = "INSERT INTO $table
        (email
            ,username
            ,password
            ,gambar)
        VALUES (:email
            ,:username
            ,:password
            ,:gambar)";

        $stmt = $config->prepare($sql_Add_Query);
        if ($stmt->execute([
            ':email' => $email,
            ':username' => $username,
            ':password' => $password,
            ':gambar' => $gambar,
        ])) {
            return true;
        } else {
            return false;
        }
        $stmt = null;
	}

	function HashPassword($password)
	{
		$algorythm1 = "md5";
		$algorythm2 = "sha256";
		$algorythm3 = "tiger192,4";
		$hash1 = hash($algorythm1, $password);
		$hash2 = hash($algorythm2, $hash1);
		$hash3 = hash($algorythm3, $hash2);

		return $hash3;
	}

	function PasswordVerify($password, $hashed_Password)
	{
		$algorythm1 = "md5";
		$algorythm2 = "sha256";
		$algorythm3 = "tiger192,4";
		$hash1 = hash($algorythm1, $password);
		$hash2 = hash($algorythm2, $hash1);
		$hash3 = hash($algorythm3, $hash2);

		if ($hash3 === $hashed_Password) {
			return true;
		} else {
			return false;
		}
	}

	function UpdateAdmin($id_admin, $username)
	{
		global $config, $table;
		$sql_Update_Query = "UPDATE $table
		SET 
		username = :username
		WHERE
		id = :id_admin";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([
			":username" =>$username,
			":id_admin" =>$id_admin
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function UpdateProfile($id_admin, $email, $username, $gambar)
	{
		global $config, $table;
		$sql_Update_Query = "UPDATE $table
		SET 
		email = :email,
		username = :username,
		gambar = :gambar
		WHERE
		id = :id_admin";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([
			":email" =>$email,
			":username" =>$username,
			":gambar" =>$gambar,
			":id_admin" =>$id_admin
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function UpdatePassword($id_admin, $password)
	{
		global $config, $table;
		$sql_Update_Query = "UPDATE $table
		SET 
		password = :password
		WHERE
		id = :id_admin";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([
			":password" =>$password,
			":id_admin" =>$id_admin
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function CountAdmins($id_admin)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE id != :id_admin";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":id_admin" => $id_admin
		])) {
			if ($column = $stmt->fetchColumn()) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function GetAdminData()
	{
		$admin_Data = [
			"id" => $this->id,
			"email" => $this->email,
			"username" => $this->username,
			"password" => $this->password,
			"gambar" => $this->gambar
		];

		return $admin_Data;
	}

	function GetAdminsData($id_admin)
	{
		global $config, $table;
		$sql_Select_Query = "SELECT *
		FROM $table WHERE id != :id_admin";

		$stmt = $config->prepare($sql_Select_Query);		
		if ($stmt->execute([
			"id_admin" => $id_admin
		])) {
			if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		} else {
			return null;
		}
		$stmt = null;
	}

	function GetAdminsDataWithLimitOffset($id_admin, $limit, $offset)
	{
		global $config, $table;
		$sql_Select_Query = "SELECT *
		FROM $table WHERE id != :id_admin
		LIMIT :limit OFFSET :offset";

		$stmt = $config->prepare($sql_Select_Query);
		$stmt->bindValue(':id_admin', (int)$id_admin, PDO::PARAM_INT);
		$stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
		$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);		
		if ($stmt->execute()) {
			if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		} else {
			return null;
		}
		$stmt = null;
	}

	function SelectAdmin($id_admin)
	{
		global $config, $table;
		$sql_Select_Query = "SELECT *
		FROM $table
		WHERE
		id = :id_admin";

		$stmt = $config->prepare($sql_Select_Query);		
		if ($stmt->execute([
			"id_admin" => $id_admin
		])) {
			if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		} else {
			return null;
		}
		$stmt = null;
	}

	function CheckStatusAdmin($id_admin)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT status 
		FROM $table
		WHERE id = :id";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":id" => $id_admin
		])) {
			$status = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($status['status'] == "Aktif") {
				$return_Value = [
					"msg" => "Admin saat ini sedang aktif",
					"value" => false 
				];
				return $return_Value;
			} elseif ($status['status'] == "Nonaktif") {
				$return_Value = [
					"value" => true 
				];
				return $return_Value;
			} else {
				$return_Value = [
					"msg" => "Fungsi gagal",
					"value" => false 
				];
				return $return_Value;
			}
		}
		$stmt = null;
	}

	function UpdateStatusAdmin($id_admin)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT status 
		FROM $table
		WHERE id = :id";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":id" => $id_admin
		])) {
			$status = $stmt->fetch(PDO::FETCH_ASSOC);
			$stmt = null;
			if ($status['status'] == "Aktif") {
				$sql_Update_Query = "UPDATE $table
				SET 
				status = :status
				WHERE id = :id_admin";

				$stmt = $config->prepare($sql_Update_Query);
				if ($stmt->execute([
					":status" => "Nonaktif",
					":id_admin" => $id_admin
				])) {
					$return_Value = [
						"value" => true 
					];
					return $return_Value;	
				} else {
					$return_Value = [
						"msg" => "Gagal memperbarui status",
						"value" => false 
					];
					return $return_Value;
				}
			} elseif ($status['status'] == "Nonaktif") {
				$sql_Update_Query = "UPDATE $table
				SET 
				status = :status
				WHERE id = :id_admin";

				$stmt = $config->prepare($sql_Update_Query);
				if ($stmt->execute([
					":status" => "Aktif",
					":id_admin" => $id_admin
				])) {
					$return_Value = [
						"value" => true 
					];
					return $return_Value;	
				} else {
					$return_Value = [
						"msg" => "Gagal memperbarui status",
						"value" => false 
					];
					return $return_Value;
				}
			} else {
				$return_Value = [
					"msg" => "Fungsi gagal",
					"value" => false 
				];
				return $return_Value;
			}
		}
		$stmt = null;
	}

	function DeleteAdmin($id_admin)
	{
		global $config, $table;
		$sql_Delete_Query = "DELETE 
		FROM $table
		WHERE id = :id";

		$stmt = $config->prepare($sql_Delete_Query);
		if ($stmt->execute([
			":id" => $id_admin
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function GenerateToken($length = 32)
	{
		$token = bin2hex(random_bytes($length));

		return $token;
	}

	function InsertToken($id_admin, $token, $expired)
	{
		global $config, $table_token;
		$sql_Add_Query = "INSERT INTO
		$table_token 
		(id_admin,
			token,
			expired)
		VALUES
		(:id_admin,
			:token,
			:expired)";

		$stmt = $config->prepare($sql_Add_Query);
		if ($stmt->execute([
			":id_admin" => $id_admin,
			":token" => $token,
			":expired" => $expired
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function CheckToken($token, $time)
	{
		global $config, $table_token;
		$sql_Check_Query = "SELECT COUNT(*) 
		FROM 
		$table_token
		WHERE
		token = :token
		AND
		expired > NOW()";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":token" => $token
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return true;
			} else {
				return false;
			}
		}
		$stmt = null;
	}

	function DeleteToken($token)
	{
		global $config, $table_token;
		$sql_Delete_Query = "DELETE FROM 
		$table_token
		WHERE
		token = :token";

		$stmt = $config->prepare($sql_Delete_Query);
		if ($stmt->execute([
			":token" => $token
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function CheckActiveTime($id_admin)
	{
		global $config, $table;

		$now_time = new DateTime();
		$now_time->modify("-1 month");
		$sql_Select_Query = "SELECT last_login 
		FROM $table
		WHERE
		id = :id_admin";
		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":id_admin" => $id_admin
		])) {
			$admin = $stmt->fetch(PDO::FETCH_ASSOC);
			$last_login = $admin['last_login'];

			if (!is_null($last_login)) {
				$active_time = new DateTime($last_login);
				if ($now_time->format("Y-m-d H:i:s") > $active_time->format("Y-m-d H:i:s")) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
		$stmt = null;
	}

	function UpdateActiveTime($id_admin)
	{
		global $config, $table;
		$sql_Update_Query = "UPDATE $table
		SET 
		last_login = NOW()
		WHERE
		id = :id_admin";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([
			":id_admin" =>$id_admin
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}
}
/**
 * 
 */
class Produk
{
	function CheckProduk($nama_produk)
	{
		global $config, $table_produk;
		$sql_Check_Query = "SELECT COUNT(*) 
		FROM $table_produk
		WHERE
		nama_produk = :nama_produk";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":nama_produk" => $nama_produk
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function CheckProdukDuplication($nama_produk, $id_produk)
	{
		global $config, $table_produk;
		$sql_Check_Query = "SELECT COUNT(*) 
		FROM $table_produk
		WHERE
		nama_produk = :nama_produk
		AND
		id_produk != :id_produk";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":nama_produk" => $nama_produk,
			":id_produk" => $id_produk
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function CheckVarian($varian, $nama_produk)
	{
		global $config, $table_produk, $table_varian;
		$sql_Select_Query = "SELECT id_produk 
		FROM $table_produk
		WHERE
		nama_produk = :nama_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":nama_produk" => $nama_produk
		])) {
			if ($produk = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$stmt = null;
				$id_Produk = $produk['id_produk'];

				$sql_Check_Query = "SELECT COUNT(*)
				FROM $table_varian
				WHERE
				varian = :varian
				AND
				fid_produk = :id_produk";

				$stmt = $config->prepare($sql_Check_Query);
				if ($stmt->execute([
					":varian" => $varian,
					":id_produk" => $id_Produk
				])) {
					$column = $stmt->fetchColumn();
					if ($column > 0) {
						return $column;
					} else {
						return null;
					}
				}
			}
		}
		$stmt = null;
	}

	function CheckVarianDuplication($varian, $id_varian, $id_produk)
	{
		global $config, $table_produk, $table_varian;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table_varian
		WHERE
		varian = :varian
		AND
		fid_produk = :id_produk
		AND
		id != :id_varian";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":varian" => $varian,
			":id_produk" => $id_produk,
			":id_varian" => $id_varian
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function SelectProduks()
	{
		global $config, $table_produk;
		$sql_Select_Query = "SELECT * FROM $table_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute()) {
			$result_Produk = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result_Produk;
		} else {
			return null;
		}
	}

	function SelectProduksByKategori($id_kategori)
	{
		global $config, $table_produk;
		$sql_Select_Query = "SELECT * FROM $table_produk WHERE fid_kategori = :id_kategori";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":id_kategori" => $id_kategori
		])) {
			$result_Produk = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result_Produk;
		} else {
			return null;
		}
	}

	function SelectProduk1($id_produk)
	{
		global $config, $table_produk;
		$sql_Select_Query = "SELECT * FROM $table_produk WHERE id_produk = :id_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":id_produk" => $id_produk
		])) {
			$result_Produk = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result_Produk;
		} else {
			return null;
		}
		$stmt = null;
	}

	function SelectProduk2($nama_produk)
	{
		global $config, $table_produk;
		$sql_Select_Query = "SELECT * FROM $table_produk WHERE nama_produk = :nama_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":nama_produk" => $nama_produk
		])) {
			$result_Produk = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result_Produk;
		} else {
			return null;
		}
		$stmt = null;
	}

	function SelectProduk($id_produk, $nama_produk)
	{
		if (!is_null($id_produk) && is_null($nama_produk)) {
			return $this->SelectProduk1($id_produk);
		} elseif (!is_null($nama_produk) && is_null($id_produk)) {
			return $this->SelectProduk2($nama_produk);
		} else {
			return null;
		}
	}

	function SelectVarians($id_produk)
	{
		global $config, $table_varian;
		$sql_Select_Query = "SELECT * FROM $table_varian WHERE fid_produk = :id_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":id_produk" => $id_produk
		])) {
			$result_Varian = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result_Varian;
		} else {
			return null;
		}
		$stmt = null;
	}

	function SelectFromBarcode($barcode)
	{
		global $config, $table_varian;
		$sql_Select_Query = "SELECT * FROM $table_varian WHERE kode_bar = :barcode";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			"barcode" => $barcode
		])) {
			if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		} else {
			return null;
		}
	}

	function SelectVarian1($id_varian, $id_produk)
	{
		global $config, $table_varian;
		$sql_Select_Query = "SELECT * 
		FROM $table_varian 
		WHERE
		id = :id_varian
		AND 
		fid_produk = :id_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":id_varian" => $id_varian,
			":id_produk" => $id_produk
		])) {
			$result_Varian = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result_Varian;
		} else {
			return null;
		}
		$stmt = null;
	}

	function SelectVarian2($varian, $id_produk)
	{
		global $config, $table_varian;
		$sql_Select_Query = "SELECT * 
		FROM $table_varian 
		WHERE
		varian = :varian
		AND 
		fid_produk = :id_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":varian" => $varian,
			":id_produk" => $id_produk
		])) {
			$result_Varian = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result_Varian;
		} else {
			return null;
		}
		$stmt = null;
	}

	function SelectVarian3($id_varian, $nama_produk)
	{
		global $config, $table_produk, $table_varian;
		$sql_Select_Query = "SELECT id_produk 
		FROM $table_produk
		WHERE
		nama_produk = :nama_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":nama_produk" => $nama_produk
		])) {
			if ($produk = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$stmt = null;
				$id_Produk = $produk['id_produk'];

				$sql_Select_Query = "SELECT * 
				FROM $table_varian 
				WHERE
				id = :id_varian
				AND 
				fid_produk = :id_produk";

				$stmt = $config->prepare($sql_Select_Query);
				if ($stmt->execute([
					":id_varian" => $id_varian,
					":id_produk" => $id_Produk
				])) {
					$result_Varian = $stmt->fetch(PDO::FETCH_ASSOC);
					return $result_Varian;
				} else {
					return null;
				}
			}
		}
		$stmt = null;
	}

	function SelectVarian4($varian, $nama_produk)
	{
		global $config, $table_produk, $table_varian;
		$sql_Select_Query = "SELECT id_produk 
		FROM $table_produk
		WHERE
		nama_produk = :nama_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":nama_produk" => $nama_produk
		])) {
			if ($produk = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$stmt = null;
				$id_Produk = $produk['id_produk'];

				$sql_Select_Query = "SELECT * 
				FROM $table_varian 
				WHERE
				varian = :varian
				AND 
				fid_produk = :id_produk";

				$stmt = $config->prepare($sql_Select_Query);
				if ($stmt->execute([
					":varian" => $varian,
					":id_produk" => $id_Produk
				])) {
					$result_Varian = $stmt->fetch(PDO::FETCH_ASSOC);
					return $result_Varian;
				} else {
					return null;
				}
			}
		}
		$stmt = null;
	}

	function SelectVarian($id_varian, $id_produk, $varian, $nama_produk)
	{
		if (
			!is_null($id_varian) &&
			!is_null($id_produk) &&
			is_null($varian) &&
			is_null($nama_produk)
		) {
			return $this->SelectVarian1($id_varian, $id_produk);
		} elseif (
			is_null($id_varian) &&
			!is_null($id_produk) &&
			!is_null($varian) &&
			is_null($nama_produk)
		) {
			return $this->SelectVarian2($varian, $id_produk);
		} elseif (
			!is_null($id_varian) &&
			is_null($id_produk) &&
			is_null($varian) &&
			!is_null($nama_produk)
		) {
			return $this->SelectVarian3($id_varian, $nama_produk);
		} elseif (
			is_null($id_varian) &&
			is_null($id_produk) &&
			!is_null($varian) &&
			!is_null($nama_produk)
		) {
			return $this->SelectVarian4($varian, $nama_produk);
		} else {
			return null;
		}
	}

	function AddProduk($nama_produk, $id_kategori, $deskripsi)
	{
		global $config, $table_produk;
		$sql_Add_Query = "INSERT INTO $table_produk
		(nama_produk,
			fid_kategori,
			deskripsi)
		VALUES
		(:nama_produk,
			:id_kategori,
			:deskripsi)";

		$stmt = $config->prepare($sql_Add_Query);
		if ($stmt->execute([
			":nama_produk" => $nama_produk,
			"id_kategori" => $id_kategori,
			":deskripsi" => $deskripsi
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function AddVarian($nama_produk, $varian, $tanggal_expired, $stok, $modal, $harga_jual, $keuntungan, $gambar, $kode_bar)
	{
		global $config, $table_produk, $table_varian;
		$sql_Select_Query = "SELECT id_produk 
		FROM $table_produk
		WHERE
		nama_produk = :nama_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":nama_produk" => $nama_produk
		])) {
			if ($produk = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$stmt = null;
				$id_produk = $produk['id_produk'];

				$sql_Add_Query = "INSERT INTO $table_varian
				(fid_produk,
					varian,
					tanggal_expired,
					stok,
					modal,
					harga_jual,
					keuntungan_per_produk,
					gambar,
					kode_bar)
				VALUES
				(:id_produk,
					:varian,
					:tanggal_expired,
					:stok,
					:modal,
					:harga_jual,
					:keuntungan,
					:gambar,
					:kode_bar)";

				$stmt = $config->prepare($sql_Add_Query);
				if ($stmt->execute([
					":id_produk" => $id_produk,
					"varian" => $varian,
					"tanggal_expired" => $tanggal_expired,
					"stok" => $stok,
					"modal" => $modal,
					"harga_jual" => $harga_jual,
					"keuntungan" => $keuntungan,
					":gambar" => $gambar,
					":kode_bar" => $kode_bar
				])) {
					return true;
				} else {
					return false;
				}
			}
		}
		$stmt = null;
	}

	function UpdateProduk($id_produk, $nama_produk, $id_kategori, $deskripsi)
	{
		global $config, $table_produk;
		$sql_Update_Query = "UPDATE $table_produk
		SET
		nama_produk = :nama_produk,
		fid_kategori = :id_kategori,
		deskripsi = :deskripsi
		WHERE
		id_produk = :id_produk";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([
			":nama_produk" => $nama_produk,
			":id_kategori" => $id_kategori,
			":deskripsi" => $deskripsi,
			":id_produk" => $id_produk
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function UpdateVarianA($id_varian, $varian, $tanggal_expired, $stok, $modal, $harga_jual, $keuntungan, $gambar)
	{
		global $config, $table_varian;
		$sql_Update_Query = "UPDATE $table_varian
		SET
		varian = :varian,
		tanggal_expired = :tanggal_expired,
		stok = stok + :stok,
		modal = :modal,
		harga_jual = :harga_jual,
		keuntungan_per_produk = :keuntungan,
		gambar = :gambar
		WHERE
		id = :id_varian";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([
			":varian" => $varian,
			":tanggal_expired" => $tanggal_expired,
			":stok" => $stok,
			":modal" => $modal,
			":harga_jual" => $harga_jual,
			":keuntungan" => $keuntungan,
			":gambar" => $gambar,
			":id_varian" => $id_varian
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function UpdateVarianB($id_varian, $varian, $tanggal_expired, $stok, $modal, $harga_jual, $keuntungan, $gambar)
	{
		global $config, $table_varian;
		$sql_Update_Query = "UPDATE $table_varian
		SET
		varian = :varian,
		tanggal_expired = :tanggal_expired,
		stok = :stok,
		modal = :modal,
		harga_jual = :harga_jual,
		keuntungan_per_produk = :keuntungan,
		gambar = :gambar
		WHERE
		id = :id_varian";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([
			":varian" => $varian,
			":tanggal_expired" => $tanggal_expired,
			":stok" => $stok,
			":modal" => $modal,
			":harga_jual" => $harga_jual,
			":keuntungan" => $keuntungan,
			":gambar" => $gambar,
			":id_varian" => $id_varian
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function UpdateStok($id_varian, $id_produk, $stok)
	{
		global $config, $table_varian;
		$sql_Update_Query = "UPDATE $table_varian
		SET
		stok = :stok
		WHERE
		id = :id_varian
		AND
		fid_produk = :id_produk";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([
			":stok" => $stok,
			":id_varian" => $id_varian,
			":id_produk" => $id_produk
		])) {
			return true;
		} else {
			return false;
		}
	}

	function SubtractStok($jumlah, $id_varian)
	{
		global $config, $table_varian;
		$sql_Update_Query = "UPDATE $table_varian
		SET
		stok = stok - :jumlah
		WHERE
		id = :id_varian";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([
			":jumlah" => $jumlah,
			":id_varian" => $id_varian
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function AddStok($jumlah, $id_varian)
	{
		global $config, $table_varian;
		$sql_Update_Query = "UPDATE $table_varian
		SET
		stok = stok + :jumlah
		WHERE
		id = :id_varian";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([
			":jumlah" => $jumlah,
			":id_varian" => $id_varian
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function AddSold($jumlah, $id_varian)
	{
		global $config, $table_varian;
		$sql_Update_Query = "UPDATE $table_varian
		SET
		terjual = terjual + :jumlah
		WHERE
		id = :id_varian";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([
			":jumlah" => $jumlah,
			":id_varian" => $id_varian
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}
}
/**
 * 
 */
class Kategori
{
	
	function CheckKategori($kategori)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE
		kategori = :kategori";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":kategori" => $kategori
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function CheckKategoriUpdate($kategori, $id_kategori)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE
		kategori = :kategori
		AND
		id_kategori != :id_kategori";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":kategori" => $kategori,
			":id_kategori" => $id_kategori
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function AddKategori($kategori, $gambar)
	{
		global $config, $table;
		$sql_Add_Query = "INSERT INTO $table
		(kategori, 
			gambar)
		VALUES
		(:kategori, 
			:gambar)";

		$stmt = $config->prepare($sql_Add_Query);
		if ($stmt->execute([
			":kategori" => $kategori,
			":gambar" => $gambar
		])) {
			return true;
		} else {
			return false;
		}
	}

	function SelectKategori($id_kategori)
	{
		global $config, $table;
		$sql_Select_Query = "SELECT * FROM
		$table
		WHERE
		id_kategori = :id_kategori";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":id_kategori" => $id_kategori
		])) {
			if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function CountProduk($id_kategori)
	{
		global $config, $table_produk;
		$sql_Check_Query = "SELECT COUNT(*) FROM
		$table_produk
		WHERE
		fid_kategori = :id_kategori";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":id_kategori" => $id_kategori
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function SelectKategoris()
	{
		global $config, $table;
		$sql_Select_Query = "SELECT * FROM $table";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute()) {
			if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function UpdateKategori($kategori, $gambar, $id_kategori)
	{
		global $config, $table;
		$sql_Update_Query = "UPDATE $table
		SET
		kategori = :kategori,
		gambar = :gambar
		WHERE
		id_kategori = :id_kategori";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([ 
			"kategori" => $kategori,
			"gambar" => $gambar,
			":id_kategori" => $id_kategori
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function DeleteKategori($id_kategori)
	{
		global $config, $table;
		$sql_Delete_Query = "DELETE 
		FROM $table
		WHERE id_kategori = :id_kategori";

		$stmt = $config->prepare($sql_Delete_Query);
		if ($stmt->execute([
			":id_kategori" => $id_kategori
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}
}
/**
 * 
 */
class Member
{
	
	function CheckMember($no_telp)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE
		no_telp = :no_telp";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":no_telp" => $no_telp
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function CheckMemberUpdate($no_telp, $id_member)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE
		no_telp = :no_telp
		AND
		id_member != :id_member";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":no_telp" => $no_telp,
			":id_member" => $id_member
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function CountMembers()
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute()) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function AddMember($nama, $no_telp)
	{
		global $config, $table;
		$sql_Add_Query = "INSERT INTO $table
		(nama_member, no_telp)
		VALUES
		(:nama, :no_telp)";

		$stmt = $config->prepare($sql_Add_Query);
		if ($stmt->execute([
			":nama" => $nama,
			":no_telp" => $no_telp
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function SelectMember($id_member)
	{
		global $config, $table;
		$sql_Select_Query = "SELECT * FROM
		$table
		WHERE
		id_member = :id_member";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":id_member" => $id_member
		])) {
			if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function SelectMembers()
	{
		global $config, $table;
		$sql_Select_Query = "SELECT * FROM $table";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute()) {
			if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function SelectMembersWithOffsetLimit($limit, $offset)
	{
		global $config, $table;
		$sql_Select_Query = "SELECT * FROM $table LIMIT :limit OFFSET :offset";

		$stmt = $config->prepare($sql_Select_Query);
		$stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
		$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
		if ($stmt->execute()) {
			if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function UpdateMember($nama, $no_telp, $id_member)
	{
		global $config, $table;
		$sql_Update_Query = "UPDATE $table
		SET
		nama_member = :nama,
		no_telp = :no_telp
		WHERE
		id_member = :id_member";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([ 
			"nama" => $nama,
			"no_telp" => $no_telp,
			"id_member" => $id_member
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function DeleteMember($id_member)
	{
		global $config, $table;
		$sql_Delete_Query = "DELETE 
		FROM $table
		WHERE id_member = :id_member";

		$stmt = $config->prepare($sql_Delete_Query);
		if ($stmt->execute([
			":id_member" => $id_member
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function AddPoint($id_member, $gained_point)
	{
		global $config, $table;
		$sql_Update_Query = "UPDATE $table
		SET
		point = point + :gained_point
		WHERE
		id_member = :id_member";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([
			":gained_point" => $gained_point,
			":id_member" => $id_member
		])) {
			return true;
		} else {
			return false;
		}
	}

	function SubtractPoint($id_member, $point_usage)
	{
		global $config, $table;
		$sql_Update_Query = "UPDATE $table
		SET
		point = point - :point_usage
		WHERE
		id_member = :id_member";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([
			":point_usage" => $point_usage,
			":id_member" => $id_member
		])) {
			return true;
		} else {
			return false;
		}
	}

	function UpdateActiveTime($id_member)
	{
		global $config, $table;
		$sql_Update_Query = "UPDATE $table
		SET 
		last_transaction = NOW()
		WHERE
		id_member = :id_member";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([
			":id_member" =>$id_member
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function CheckActiveTime($id_member)
	{
		global $config, $table;

		$now_time = new DateTime();
		$now_time->modify("-1 month");
		$sql_Select_Query = "SELECT last_transaction 
		FROM $table
		WHERE
		id_member = :id_member";
		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":id_member" => $id_member
		])) {
			$member = $stmt->fetch(PDO::FETCH_ASSOC);
			$last_transaction = $member['last_transaction'];

			if (!is_null($last_transaction)) {
				$active_time = new DateTime($last_transaction);
				if ($now_time->format("Y-m-d H:i:s") > $active_time->format("Y-m-d H:i:s")) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
		$stmt = null;
	}

	function UpdateStatusMemberToInactive($id_member)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT status 
		FROM $table
		WHERE id_member = :id_member";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":id_member" => $id_member
		])) {
			$status = $stmt->fetch(PDO::FETCH_ASSOC);
			$stmt = null;
			if ($status['status'] == "aktif") {
				$sql_Update_Query = "UPDATE $table
				SET 
				status = :status
				WHERE id_member = :id_member";

				$stmt = $config->prepare($sql_Update_Query);
				if ($stmt->execute([
					":status" => "tidak aktif",
					":id_member" => $id_member
				])) {
					$return_Value = [
						"value" => true 
					];
					return $return_Value;	
				} else {
					$return_Value = [
						"msg" => "Gagal memperbarui status",
						"value" => false 
					];
					return $return_Value;
				}
			}
		}
		$stmt = null;
	}

	function UpdateStatusMemberToActive($id_member)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT status 
		FROM $table
		WHERE id_member = :id_member";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":id_member" => $id_member
		])) {
			$status = $stmt->fetch(PDO::FETCH_ASSOC);
			$stmt = null;
			if ($status['status'] == "tidak aktif") {
				$sql_Update_Query = "UPDATE $table
				SET 
				status = :status
				WHERE id_member = :id_member";

				$stmt = $config->prepare($sql_Update_Query);
				if ($stmt->execute([
					":status" => "aktif",
					":id_member" => $id_member
				])) {
					$return_Value = [
						"value" => true 
					];
					return $return_Value;	
				} else {
					$return_Value = [
						"msg" => "Gagal memperbarui status",
						"value" => false 
					];
					return $return_Value;
				}
			} else {
				$return_Value = [
					"value" => true 
				];
				return $return_Value;	
			}
		}
		$stmt = null;
	}
}
/**
 * 
 */
class Cart implements Countable
{
	public array $cart = [];

	function __construct()
	{
		$this->cart = [];
	}

	function AddItems($id_produk, $id_varian, $nama_produk, $varian, $harga_jual, $jumlah, $tanggal_expired, $gambar, $stok)
	{
		if (!isset($this->cart[$id_produk])) {
			$this->cart[$id_produk] = [];
		}

		if (isset($this->cart[$id_produk][$id_varian])) {
			$this->cart[$id_produk][$id_varian]["jumlah"] += $jumlah;
		} else {
			$this->cart[$id_produk][$id_varian] = [
				"id_produk" => $id_produk,
				"id_varian" => $id_varian,
				"nama_produk" => $nama_produk,
				"varian" => $varian,
				"harga_jual" => $harga_jual,
				"jumlah" => $jumlah,
				"tanggal_expired" => $tanggal_expired,
				"gambar" => $gambar,
				"stok" => $stok
			];
		}
		return isset($this->cart[$id_produk][$id_varian]);
	}

	function GetItems()
	{
		return $this->cart;
	}

	function DeleteItems($id_produk, $id_varian)
	{
		if (isset($this->cart[$id_produk][$id_varian])) {
			unset($this->cart[$id_produk][$id_varian]);
			if (empty($this->cart[$id_produk])) {
				unset($this->cart[$id_produk]);
			}	
		}
	}

	function count(): int {
        return count($this->cart);
    }

	function DeleteAllItems()
	{
		if (isset($this->cart)) {
			unset($this->cart);
		}
	}
}
/**
 * 
 */
class Transaksi
{
	public array $transaksi = [];

	function __construct()
	{
		$this->transaksi = [];
	}

	function AddTransaksi($id_produk, $id_varian, $nama_produk, $varian, $subtotal, $jumlah)
	{
		if (!isset($this->transaksi[$id_produk])) {
			$this->transaksi[$id_produk] = [];
		}

		if (isset($this->transaksi[$id_produk][$id_varian])) {
			$this->transaksi[$id_produk][$id_varian]["jumlah"] += $jumlah;
			$this->transaksi[$id_produk][$id_varian]["subtotal"] += $subtotal;
		} else {
			$this->transaksi[$id_produk][$id_varian] = [
				"id_produk" => $id_produk,
				"id_varian" => $id_varian,
				"nama_produk" => $nama_produk,
				"varian" => $varian,
				"subtotal" => $subtotal,
				"jumlah" => $jumlah
			];
		}
		return isset($this->transaksi[$id_produk][$id_varian]);
	}

	function GetTransaksi()
	{
		return $this->transaksi;
	}

	function DeleteTransaksi($id_produk, $id_varian)
	{
		if (isset($this->transaksi[$id_produk][$id_varian])) {
			unset($this->transaksi[$id_produk][$id_varian]);
			if (empty($this->transaksi[$id_produk])) {
				unset($this->transaksi[$id_produk]);
			}	
		}
	}

	function DeleteAllTransaksi()
	{
		if (isset($this->transaksi)) {
			unset($this->transaksi);
			return true;
		} else {
			return false;
		}
	}

	function SendToTableTransaksi($kode_unik, $tanggal_pembelian, $total_harga, $fid_admin, $total_bayar, $total_diskon, $fid_metode_pembayaran, $total_kembalian, $total_keuntungan)
	{
		global $config, $table_transaksi;

		$sql_Add_Query = "INSERT INTO $table_transaksi
		(kode_unik,
			tanggal_pembelian,
			total_harga,
			fid_admin,
			total_bayar,
			total_diskon,
			fid_metode_pembayaran,
			total_kembalian,
			total_keuntungan
			)
		VALUES
		(:kode_unik,
			:tanggal_pembelian,
			:total_harga,
			:fid_admin,
			:total_bayar,
			:total_diskon,
			:fid_metode_pembayaran,
			:total_kembalian,
			:total_keuntungan)
		";

		$stmt = $config->prepare($sql_Add_Query);

		if ($stmt->execute([
			":kode_unik" => $kode_unik,
			":tanggal_pembelian" => $tanggal_pembelian,
			":total_harga" => $total_harga,
			":fid_admin" => $fid_admin,
			":total_bayar" => $total_bayar,
			":total_diskon" => $total_diskon,
			":fid_metode_pembayaran" => $fid_metode_pembayaran,
			":total_kembalian" => $total_kembalian,
			":total_keuntungan" => $total_keuntungan,
		])) {
			return true;
		} else {
			return false;
		}
	}

	function SendToTableDetailTransaksi($kode_unik, $fid_detail_produk, $fid_member, $total_produk, $subtotal)
	{
		global $config, $table_transaksi, $table_detail_transaksi;

		$sql_Select_Query = "SELECT id_transaksi FROM $table_transaksi WHERE kode_unik = :kode_unik";
		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":kode_unik" => $kode_unik
		])) {
			if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$id_transaksi = $result['id_transaksi'];

				$sql_Add_Query = "INSERT INTO $table_detail_transaksi
				(fid_transaksi, fid_detail_produk, fid_member, total_produk, subtotal)
				VALUES (:fid_transaksi, :fid_detail_produk, :fid_member, :total_produk, :subtotal)";

				$stmt = $config->prepare($sql_Add_Query);

				if ($stmt->execute([
					":fid_transaksi" => $id_transaksi,
					":fid_detail_produk" => $fid_detail_produk,
					":fid_member" => $fid_member,
					":total_produk" => $total_produk,
					":subtotal" => $subtotal
				])) {
					return true;
				} else {
					return false;
				}
			}
		}
	}

	function SelectPaymentMethods()
	{
		global $config, $table_metode;
		$sql_Select_Query = "SELECT * FROM $table_metode";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute()) {
			if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
}
/**
 * 
 */
class Laporan
{
	function SelectAllLaporan()
	{
		global $config, $table_transaksi;

		$sql_Select_Query = "SELECT SUM(total_harga) AS total FROM $table_transaksi GROUP BY tanggal_pembelian";
		$stmt = $config->prepare($sql_Select_Query);

		if ($stmt->execute()) {
			if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		} else {
			return null;
		}
	}

	function SelectLaporanThisDay()
	{
		global $config, $table_transaksi;

		$sql_Select_Query = "SELECT * FROM $table_transaksi WHERE tanggal_pembelian = :tanggal_pembelian";
		$stmt = $config->prepare($sql_Select_Query);

		if ($stmt->execute([
			":tanggal_pembelian" => "2025-04-18"
		])) {
			if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
	}

	function SelectLaporanThisWeek()
	{
		global $config, $table_transaksi;

		$sql_Select_Query = "SELECT SUM(total_harga) AS total, DAYNAME(tanggal_pembelian) AS hari FROM $table_transaksi WHERE YEARWEEK(tanggal_pembelian, 1) = YEARWEEK(CURDATE(), 1) GROUP BY DAYNAME(tanggal_pembelian)";
		$stmt = $config->prepare($sql_Select_Query);

		if ($stmt->execute()) {
			if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
	}

	function SelectModalProduk()
	{
		global $config, $table_produk;

		$sql_Select_Query = "SELECT modal FROM $table_produk";
		$stmt = $config->prepare($sql_Select_Query);

		if ($stmt->execute()) {
			if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
	}

	function AddLaporan($total_modal, $total_penjualan, $total_keuntungan)
	{
		global $config, $table_laporan;

		$sql_Add_Query = "INSERT INTO $table_laporan 
		(
			total_penjualan, 
			total_modal, 
			total_keuntungan
		) VALUES (
		:total_penjualan, 
		:total_modal, 
		:total_keuntungan)";


	}

	function SelectLaporan($tahun, $bulan, $tanggal)
	{
		global $config, $table_transaksi;

		$sql_Select_Query = "SELECT SUM(total_harga) AS total FROM $table_transaksi WHERE 1=1";
		$params = [];

		if ($tahun) {
			$sql_Select_Query .= " AND YEAR(tanggal_pembelian) = :tahun";
			$params[':tahun'] = $tahun;
		} 

		if ($bulan) {
			$sql_Select_Query .= " AND MONTH(tanggal_pembelian) = :bulan";
			$params[':bulan'] = $bulan;
		} 

		if ($tanggal) {
			$sql_Select_Query .= " AND DAY(tanggal_pembelian) = :tanggal";
			$params[':tanggal'] = $tanggal;
		}

		$sql_Select_Query .= " GROUP BY tanggal_pembelian"; 

		$stmt = $config->prepare($sql_Select_Query);

		if ($stmt->execute($params)) {
			if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
	}

	function SelectLaporan2($tanggal)
	{
		global $config, $table_transaksi;

		$sql_Select_Query = "SELECT ";
	}
}
?>